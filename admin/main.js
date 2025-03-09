document.addEventListener('DOMContentLoaded', function() {
    // Variables globales
    const sidebar = document.querySelector('.sidebar');
    const menuToggle = document.getElementById('menuToggle');
    const mainContent = document.querySelector('.main-content');
    const dropdowns = document.querySelectorAll('.nav-item-dropdown');
    const adminProfile = document.querySelector('.admin-profile');
    const profileDropdown = document.querySelector('.profile-dropdown');

    // Fonction pour fermer tous les dropdowns
    function closeAllDropdowns() {
        dropdowns.forEach(dropdown => {
            dropdown.classList.remove('active');
            const submenu = dropdown.querySelector('.submenu');
            if (submenu) {
                submenu.style.maxHeight = null;
            }
        });
    }

    // Fonction pour fermer le profile dropdown
    function closeProfileDropdown() {
        if (profileDropdown) {
            profileDropdown.classList.remove('show');
        }
    }

    // Toggle Sidebar
    if (menuToggle) {
        menuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('expanded');
        });
    }

    // Gestion des dropdowns du sidebar
    dropdowns.forEach(dropdown => {
        const dropdownLink = dropdown.querySelector('a');
        const submenu = dropdown.querySelector('.submenu');
        
        if (dropdownLink) {
            dropdownLink.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

                // Ferme les autres dropdowns
                dropdowns.forEach(otherDropdown => {
                    if (otherDropdown !== dropdown) {
                        otherDropdown.classList.remove('active');
                        const otherSubmenu = otherDropdown.querySelector('.submenu');
                        if (otherSubmenu) {
                            otherSubmenu.style.maxHeight = null;
                        }
                    }
                });

                // Toggle le dropdown actuel
                dropdown.classList.toggle('active');
                
                // Animation du submenu
                if (submenu) {
                    if (dropdown.classList.contains('active')) {
                        submenu.style.maxHeight = submenu.scrollHeight + "px";
                    } else {
                        submenu.style.maxHeight = null;
                    }
                }
            });
        }
    });

    // Gestion du profile dropdown
    if (adminProfile) {
        adminProfile.addEventListener('click', (e) => {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
        });
    }

    // Fermeture des dropdowns lors du clic à l'extérieur
    document.addEventListener('click', (e) => {
        if (!sidebar.contains(e.target)) {
            closeAllDropdowns();
        }
        if (!adminProfile?.contains(e.target)) {
            closeProfileDropdown();
        }
    });

    // Gestion des liens actifs
    function setActiveLink() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.sidebar-nav a');

        navLinks.forEach(link => {
            const linkPath = new URL(link.href, window.location.origin).pathname;
            
            if (linkPath === currentPath) {
                // Retire la classe active de tous les liens
                navLinks.forEach(l => l.parentElement.classList.remove('active'));
                
                // Ajoute la classe active au lien courant
                link.parentElement.classList.add('active');

                // Si le lien est dans un submenu, ouvre le dropdown parent
                const parentDropdown = link.closest('.nav-item-dropdown');
                if (parentDropdown) {
                    parentDropdown.classList.add('active');
                    const submenu = parentDropdown.querySelector('.submenu');
                    if (submenu) {
                        submenu.style.maxHeight = submenu.scrollHeight + "px";
                    }
                }
            }
        });
    }

    // Animation des stats cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-5px)';
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
        });
    });

    // Gestion du responsive
    function handleResize() {
        if (window.innerWidth <= 1024) {
            sidebar.classList.remove('active');
            mainContent.classList.remove('expanded');
        }
    }

    // Event listeners pour le responsive
    window.addEventListener('resize', handleResize);
    
    // Initialisation
    setActiveLink();
    handleResize();

    // Gestion des notifications (exemple)
    const notifications = document.querySelector('.notifications');
    if (notifications) {
        notifications.addEventListener('click', () => {
            // Ici vous pouvez ajouter la logique pour afficher les notifications
            alert('Notifications feature coming soon!');
        });
    }

    // Animation smooth scroll pour les liens d'ancrage
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Gestion des erreurs
    window.addEventListener('error', function(e) {
        console.error('Une erreur est survenue:', e.error);
    });
});

// Fonction utilitaire pour l'animation des nombres
function animateNumber(element, start, end, duration) {
    let current = start;
    const range = end - start;
    const increment = range / (duration / 16);
    const timer = setInterval(() => {
        current += increment;
        element.textContent = Math.round(current).toLocaleString();
        if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
            element.textContent = end.toLocaleString();
            clearInterval(timer);
        }
    }, 16);
}

// Animation des nombres dans les stats cards
document.querySelectorAll('.stat-number').forEach(stat => {
    const value = parseInt(stat.textContent.replace(/,/g, ''));
    animateNumber(stat, 0, value, 1000);
});