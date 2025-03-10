<?php include 'includes/header.php'; ?>
    <section class="type-detail-hero">
        <div class="type-detail-container">
            <div class="type-header">
                <div class="type-info">
                    <h1>Phishing par Email</h1>
                    <p>La forme la plus répandue de phishing, utilisant des emails frauduleux pour tromper les victimes.
                    </p>
                    <div class="type-stats">
                        <div class="stat-item">
                            <h4>Niveau de risque</h4>
                            <p>Élevé</p>
                        </div>
                        <div class="stat-item">
                            <h4>Cas reportés</h4>
                            <p>15,000+</p>
                        </div>
                        <div class="stat-item">
                            <h4>Taux de succès</h4>
                            <p>32%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="type-content">
        <div class="type-detail-container">
            <div class="content-grid">
                <div class="main-content">
                    <div class="content-section">
                        <h2>Description</h2>
                        <p>Le phishing par email est une technique de cyberattaque où les criminels envoient des emails
                            frauduleux qui semblent provenir d'organisations légitimes. Ces emails tentent généralement
                            de voler des informations sensibles comme les identifiants de connexion, les numéros de
                            carte bancaire ou d'autres données personnelles.</p>
                    </div>

                    <div class="content-section">
                        <h2>Comment ça fonctionne</h2>
                        <p>Les attaquants créent des emails qui imitent parfaitement ceux d'entreprises légitimes,
                            utilisant souvent leurs logos et leur mise en page. Ces emails contiennent généralement :
                        </p>
                        <ul>
                            <li>Des liens vers des sites frauduleux</li>
                            <li>Des pièces jointes malveillantes</li>
                            <li>Des demandes urgentes d'action</li>
                            <li>Des histoires convaincantes pour manipuler les victimes</li>
                        </ul>
                    </div>

                    <div class="content-section">
                        <h2>Comment se protéger</h2>
                        <div class="prevention-list">
                            <li>
                                <span class="number">1</span>
                                <div>
                                    <h4>Vérifier l'adresse de l'expéditeur</h4>
                                    <p>Examinez attentivement l'adresse email de l'expéditeur pour détecter des
                                        anomalies.</p>
                                </div>
                            </li>
                            <li>
                                <span class="number">2</span>
                                <div>
                                    <h4>Ne pas cliquer sur les liens suspects</h4>
                                    <p>Survolez les liens pour voir leur vraie destination avant de cliquer.</p>
                                </div>
                            </li>
                            <li>
                                <span class="number">3</span>
                                <div>
                                    <h4>Activer l'authentification à deux facteurs</h4>
                                    <p>Ajoutez une couche de sécurité supplémentaire à vos comptes.</p>
                                </div>
                            </li>
                        </div>
                    </div>
                </div>
                <aside class="sidebar">
                    <div class="resource-card">
                        <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3"
                            alt="Phishing Email Example" class="sidebar-image">
                    </div>
                </aside>

            </div>
        </div>
    </section>

    <section class="comments-section">
        <div class="type-detail-container">
            <h2>Commentaires et Retours d'Expérience</h2>

            <div class="comments-container">
                <div class="comment-form">
                    <h3>Partagez votre expérience</h3>
                    <textarea placeholder="Écrivez votre commentaire ici..."></textarea>
                    <button class="btn-details">Publier</button>
                </div>

                <!-- Commentaire principal -->
                <div class="comment-card">
                    <div class="comment-header">
                        <div class="comment-author">
                            <div class="author-avatar">JD</div>
                            <div class="author-info">
                                <h4>Jean Dupont</h4>
                                <span class="comment-date">Il y a 2 jours</span>
                            </div>
                        </div>
                    </div>
                    <p>J'ai récemment été confronté à une tentative de phishing très sophistiquée. L'email semblait
                        provenir de ma banque et tout paraissait légitime. Heureusement, j'ai vérifié l'adresse de
                        l'expéditeur qui était légèrement différente.</p>
                    <div class="comment-actions">
                        <button class="action-btn reply-btn">Répondre</button>
                        <button class="action-btn like-btn">J'aime (12)</button>
                    </div>

                    <!-- Réponses -->
                    <div class="replies">
                        <div class="comment-card">
                            <div class="comment-header">
                                <div class="comment-author">
                                    <div class="author-avatar">ML</div>
                                    <div class="author-info">
                                        <h4>Marie Laurent</h4>
                                        <span class="comment-date">Il y a 1 jour</span>
                                    </div>
                                </div>
                            </div>
                            <p>La même chose m'est arrivée ! Comment avez-vous signalé cette tentative ?</p>
                            <div class="comment-actions">
                                <button class="action-btn reply-btn">Répondre</button>
                                <button class="action-btn like-btn">J'aime (5)</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        // JavaScript pour la gestion des commentaires
        document.querySelectorAll('.reply-btn').forEach(button => {
            button.addEventListener('click', () => {
                const commentCard = button.closest('.comment-card');
                const replyForm = document.createElement('div');
                replyForm.className = 'comment-form';
                replyForm.innerHTML = `
                    <textarea placeholder="Écrivez votre réponse..."></textarea>
                    <button class="btn-details">Répondre</button>
                `;

                // Vérifier si un formulaire de réponse existe déjà
                const existingForm = commentCard.querySelector('.comment-form');
                if (!existingForm) {
                    commentCard.appendChild(replyForm);
                }
            });
        });

        // Gestion des likes
        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', () => {
                const currentLikes = parseInt(button.textContent.match(/\d+/)[0]);
                button.textContent = `J'aime (${currentLikes + 1})`;
            });
        });
    </script>
<?php include 'includes/footer.php'; ?>