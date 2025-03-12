<?php
include 'header.php';


$errors = [];

// Si la requête est en GET, on récupère l'id et on charge les données existantes
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        exit("Identifiant manquant.");
    }
    $id = $_GET['id'];

    // Récupérer le type de phishing
    $stmt = $pdo->prepare("SELECT * FROM phishing_types WHERE id = ?");
    $stmt->execute([$id]);
    $phishingType = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$phishingType) {
        exit("Type de phishing non trouvé.");
    }
    $title = $phishingType['title'];
    $description = $phishingType['description'];
    $active = $phishingType['active'];
    $imagePath = $phishingType['image'];

    // Récupérer les caractéristiques
    $stmt = $pdo->prepare("SELECT content FROM characteristics WHERE phishing_type_id = ? AND active = 1");
    $stmt->execute([$id]);
    $characteristics = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Récupérer les protections
    $stmt = $pdo->prepare("SELECT content FROM protections WHERE phishing_type_id = ? AND active = 1");
    $stmt->execute([$id]);
    $protections = $stmt->fetchAll(PDO::FETCH_COLUMN);
} else {
    // POST : traitement du formulaire d'édition
    $id = $_POST['id'] ?? null;
    if (!$id) {
        exit("Identifiant manquant.");
    }
    // Charger l'enregistrement actuel pour récupérer l'ancienne image le cas échéant
    $stmt = $pdo->prepare("SELECT * FROM phishing_types WHERE id = ?");
    $stmt->execute([$id]);
    $phishingType = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$phishingType) {
        exit("Type de phishing non trouvé.");
    }
    $oldImagePath = $phishingType['image'];

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $active = isset($_POST['active']) ? 1 : 0;
    $characteristics = $_POST['characteristics'] ?? [];
    $protections = $_POST['protections'] ?? [];
    $newImagePath = null;

    // Validation des champs
    if (empty($title)) {
        $errors[] = "Le titre est obligatoire.";
    }
    if (empty($description)) {
        $errors[] = "La description est obligatoire.";
    }
    if (empty($characteristics)) {
        $errors[] = "Au moins une caractéristique est requise.";
    }
    if (empty($protections)) {
        $errors[] = "Au moins une protection est requise.";
    }

    // Gestion de l'image (modification facultative)
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $uploadDir = '../uploads/type/';
        $fileType = mime_content_type($_FILES['image']['tmp_name']);
        $fileSize = $_FILES['image']['size'];

        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Le format de l'image doit être JPG, PNG, GIF ou WEBP.";
        }
        if ($fileSize > 2 * 1024 * 1024) { // 2 Mo
            $errors[] = "L'image ne doit pas dépasser 2 Mo.";
        }
        if (empty($errors)) {
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $newImagePath = $fileName;
            } else {
                $errors[] = "Erreur lors du téléchargement de l'image.";
            }
        }
    }

    if (empty($errors)) {
        try {
            $pdo->beginTransaction();

            if ($newImagePath !== null) {
                $sql = "UPDATE phishing_types SET title = ?, description = ?, image = ?, active = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$title, $description, $newImagePath, $active, $id]);
            } else {
                $sql = "UPDATE phishing_types SET title = ?, description = ?, active = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$title, $description, $active, $id]);
            }

            $stmt = $pdo->prepare("DELETE FROM characteristics WHERE phishing_type_id = ?");
            $stmt->execute([$id]);
            $stmt = $pdo->prepare("DELETE FROM protections WHERE phishing_type_id = ?");
            $stmt->execute([$id]);

            $stmt = $pdo->prepare("INSERT INTO characteristics (phishing_type_id, content, active) VALUES (?, ?, 1)");
            foreach ($characteristics as $char) {
                $char = trim($char);
                if (!empty($char)) {
                    $stmt->execute([$id, $char]);
                }
            }

            $stmt = $pdo->prepare("INSERT INTO protections (phishing_type_id, content, active) VALUES (?, ?, 1)");
            foreach ($protections as $prot) {
                $prot = trim($prot);
                if (!empty($prot)) {
                    $stmt->execute([$id, $prot]);
                }
            }
            $user_id = $_SESSION['user_id'] ?? null;
            $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
            $descriptionLog = "Modification du type de phishing : " . $title;
            $stmt = $pdo->prepare("INSERT INTO logs (user_id, action_type, table_name, record_id, description, ip_address) VALUES (?, 'UPDATE', 'phishing_types', ?, ?, ?)");
            $stmt->execute([$user_id, $id, $descriptionLog, $ip_address]);

            $pdo->commit();
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    createAlert("success", "Succès", "Modification réussie ! Redirection...");
                });
            </script>';
        } catch (Exception $e) {
            $pdo->rollBack();
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    createAlert("error", "Erreur", "Erreur lors de la modification : ' . addslashes($e->getMessage()) . '");
                });
            </script>';
        }
    }
}
?>
<div class="dashboard-content">
    <div class="page-header">
        <h1>Modifier un type de phishing</h1>
        <p>Modifier le type de phishing sélectionné avec ses caractéristiques et protections</p>
    </div>
    <div class="alert-container"></div>
    <div class="form-container">
        <form id="phishingForm" action="edit-phishing-type.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
            <!-- Section principale -->
            <div class="form-section">
                <div class="form-grid">
                    <!-- Titre et Statut sur la même ligne -->
                    <div class="form-group form-grid-2">
                        <label class="form-label">Titre</label>
                        <input type="text" class="form-input" name="title" value="<?= htmlspecialchars($title ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Statut</label>
                        <div class="switch-container">
                            <label class="switch">
                                <input type="checkbox" name="active" <?= isset($active) && $active ? 'checked' : '' ?>>
                                <span class="slider"></span>
                            </label>
                            <span>Actif</span>
                        </div>
                    </div>
                    <!-- Description sur toute la largeur -->
                    <div class="form-group form-grid-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-input" name="description"><?= htmlspecialchars($description ?? '') ?></textarea>
                    </div>
                    <!-- Image -->
                    <div class="form-group form-grid-3">
                        <label class="form-label">Image</label>
                        <div class="image-upload">
                            <input type="file" id="imageInput" name="image" hidden accept="image/*">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p class="image-upload-text"><?= isset($imagePath) && !empty($imagePath) ? 'Modifier l\'image' : 'Cliquez ou glissez une image ici' ?></p>
                            <img id="imagePreview" style="display: <?= isset($imagePath) && !empty($imagePath) ? 'block' : 'none' ?>; max-width: 100%; margin-top: 10px;"
                                src="<?= isset($imagePath) && !empty($imagePath) ? '../uploads/type/' . htmlspecialchars($imagePath) : '' ?>">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Section Caractéristiques et Protections -->
            <div class="form-section">
                <div class="dynamic-fields-container">
                    <!-- Caractéristiques -->
                    <div class="dynamic-section">
                        <h3 class="form-label">Caractéristiques</h3>
                        <div id="characteristicsContainer" class="dynamic-fields">
                            <?php if (!empty($characteristics)): ?>
                                <?php foreach ($characteristics as $char): ?>
                                    <div class="dynamic-field">
                                        <input type="text" class="form-input" name="characteristics[]" value="<?= htmlspecialchars($char) ?>" placeholder="Caractéristique">
                                        <button type="button" class="remove-field">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="dynamic-field">
                                    <input type="text" class="form-input" name="characteristics[]" placeholder="Caractéristique">
                                    <button type="button" class="remove-field">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="add-field" id="addCharacteristic">
                            <i class="fas fa-plus"></i>
                            Ajouter une caractéristique
                        </button>
                    </div>
                    <!-- Protections -->
                    <div class="dynamic-section">
                        <h3 class="form-label">Protections</h3>
                        <div id="protectionsContainer" class="dynamic-fields">
                            <?php if (!empty($protections)): ?>
                                <?php foreach ($protections as $prot): ?>
                                    <div class="dynamic-field">
                                        <input type="text" class="form-input" name="protections[]" value="<?= htmlspecialchars($prot) ?>" placeholder="Protection">
                                        <button type="button" class="remove-field">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="dynamic-field">
                                    <input type="text" class="form-input" name="protections[]" placeholder="Protection">
                                    <button type="button" class="remove-field">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="add-field" id="addProtection">
                            <i class="fas fa-plus"></i>
                            Ajouter une protection
                        </button>
                    </div>
                </div>
            </div>
            <!-- Boutons d'action -->
            <div class="form-actions">
                <button type="submit" class="submit-btn">
                    <i class="fas fa-save"></i>
                    Enregistrer
                </button>
                <button type="button" class="cancel-btn">
                    <i class="fas fa-times"></i>
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>
</main>
</div>
<script src="main.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageUpload = document.querySelector('.image-upload');
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const uploadText = document.querySelector('.image-upload-text');
    const uploadIcon = document.querySelector('.image-upload i');

    // Afficher l'aperçu de l'image sélectionnée
    function displayImagePreview(file) {
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                uploadText.style.display = 'none';
                uploadIcon.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    }

    imageUpload.addEventListener('click', () => imageInput.click());
    imageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        displayImagePreview(file);
    });

    imageUpload.addEventListener('dragover', (e) => {
        e.preventDefault();
        imageUpload.style.borderColor = getComputedStyle(document.documentElement).getPropertyValue('--primary');
    });

    imageUpload.addEventListener('dragleave', (e) => {
        e.preventDefault();
        imageUpload.style.borderColor = '#e5e7eb';
    });

    imageUpload.addEventListener('drop', (e) => {
        e.preventDefault();
        imageUpload.style.borderColor = '#e5e7eb';
        const file = e.dataTransfer.files[0];
        if (file) {
            imageInput.files = e.dataTransfer.files;
            displayImagePreview(file);
        }
    });

    // Fonction pour ajouter un champ dynamique
    function addDynamicField(containerId, placeholder) {
        const container = document.getElementById(containerId);
        const field = document.createElement('div');
        field.className = 'dynamic-field';
        field.innerHTML = `
            <input type="text" class="form-input" name="${containerId === 'characteristicsContainer' ? 'characteristics[]' : 'protections[]'}" placeholder="${placeholder}">
            <button type="button" class="remove-field">
                <i class="fas fa-times"></i>
            </button>
        `;
        container.appendChild(field);
        field.querySelector('.remove-field').addEventListener('click', () => {
            field.remove();
        });
    }

    document.getElementById('addCharacteristic').addEventListener('click', () => {
        addDynamicField('characteristicsContainer', 'Ajouter une caractéristique');
    });
    document.getElementById('addProtection').addEventListener('click', () => {
        addDynamicField('protectionsContainer', 'Ajouter une protection');
    });

    document.querySelectorAll('.remove-field').forEach(button => {
        button.addEventListener('click', () => {
            button.closest('.dynamic-field').remove();
        });
    });
});
</script>
</body>
</html>
