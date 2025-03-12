<?php include 'includes/header.php'; 

$stmt = $pdo->prepare("SELECT * FROM phishing_types ORDER BY id DESC LIMIT 4");
$stmt->execute();
$phishingTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

    <section class="hero">
        <div class="hero-content">
            <h1>Protégez-vous contre le Phishing</h1>
            <p>Découvrez comment identifier et vous protéger contre les cybermenaces modernes. Votre sécurité en ligne
                est notre priorité.</p>
            <button class="cta-button">Découvrir nos solutions</button>
        </div>
    </section>

    <section class="stats">
        <div class="stats-container">
            <div class="stat-card">
                <h3>80%</h3>
                <p>des entreprises victimes de phishing en 2023</p>
            </div>
            <div class="stat-card">
                <h3>3.4B€</h3>
                <p>de pertes financières annuelles</p>
            </div>
            <div class="stat-card">
                <h3>+65%</h3>
                <p>d'augmentation des cyberattaques</p>
            </div>
        </div>
    </section>

    <section class="types">
        <h2 class="section-title">Types de Phishing</h2>
        <div class="types-grid">
            <?php foreach ($phishingTypes as $type) : ?>
            <div class="type-card">
                <img src="uploads/type/<?= htmlspecialchars($type['image']) ?>" alt="<?= htmlspecialchars($type['title']) ?>">
                <h3><?= htmlspecialchars($type['title']) ?></h3>
                <p><?= htmlspecialchars(substr($type['description'], 0, 200)) ?>...</p>
                <button onclick="window.location.href='type.php?id=<?= $type['id'] ?>'" class="learn-more">Voir plus</button>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="about" id="about">
        <div class="about-container">
            <div class="about-content">
                <h2>À Propos de Nous</h2>
                <p class="about-lead">Experts en cybersécurité dédiés à votre protection</p>
                <p>Depuis plus de 10 ans, notre équipe d'experts en cybersécurité s'engage à protéger les particuliers
                    et les entreprises contre les menaces croissantes du phishing. Notre mission est de sensibiliser et
                    d'équiper chacun avec les connaissances et les outils nécessaires pour une navigation sécurisée sur
                    Internet.</p>
                <div class="about-stats">
                    <div class="about-stat">
                        <span>10+</span>
                        <p>Années d'expérience</p>
                    </div>
                    <div class="about-stat">
                        <span>5000+</span>
                        <p>Clients protégés</p>
                    </div>
                    <div class="about-stat">
                        <span>99%</span>
                        <p>Taux de satisfaction</p>
                    </div>
                </div>
            </div>
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978" alt="Notre équipe">
            </div>
        </div>
    </section>

    <section class="faq" id="faq">
        <h2 class="section-title">Questions Fréquentes</h2>
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Qu'est-ce que le phishing ?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>Le phishing est une technique frauduleuse visant à récupérer des informations personnelles en se
                        faisant passer pour une entité de confiance.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Comment reconnaître une tentative de phishing ?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>Vérifiez l'adresse email de l'expéditeur, les fautes d'orthographe, les demandes urgentes et les
                        liens suspects.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Que faire si je suis victime de phishing ?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>Changez immédiatement vos mots de passe, contactez votre banque si nécessaire et signalez
                        l'incident aux autorités compétentes.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="contact" id="contact">
        <div class="contact-container">
            <div class="contact-info">
                <h2>Nous Contacter</h2>
                <p>Une question ? N'hésitez pas à nous contacter. Notre équipe est là pour vous aider.</p>
                <div class="contact-details">
                    <div class="contact-item">
                        <span class="icon">📍</span>
                        <p>123 Rue de la Cybersécurité, 75000 Paris</p>
                    </div>
                    <div class="contact-item">
                        <span class="icon">📧</span>
                        <p>contact@cybershield.fr</p>
                    </div>
                    <div class="contact-item">
                        <span class="icon">📞</span>
                        <p>+33 1 23 45 67 89</p>
                    </div>
                </div>
            </div>
            <form class="contact-form">
                <div class="form-group">
                    <input type="text" placeholder="Votre nom" required>
                </div>
                <div class="form-group">
                    <input type="email" placeholder="Votre email" required>
                </div>
                <div class="form-group">
                    <select required>
                        <option value="">Sélectionnez un sujet</option>
                        <option value="question">Question générale</option>
                        <option value="support">Support technique</option>
                        <option value="other">Autre</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea placeholder="Votre message" required></textarea>
                </div>
                <button type="submit" class="submit-btn">Envoyer</button>
            </form>
        </div>
    </section>
<?php include 'includes/footer.php'; ?>