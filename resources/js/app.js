import './bootstrap';

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            const expanded = this.getAttribute('aria-expanded') === 'true' || false;
            this.setAttribute('aria-expanded', !expanded);
            mobileMenu.classList.toggle('hidden');
        });
    }
    
    // User menu dropdown
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = userMenuButton?.nextElementSibling;
    
    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', function() {
            const expanded = this.getAttribute('aria-expanded') === 'true' || false;
            this.setAttribute('aria-expanded', !expanded);
            userMenu.classList.toggle('hidden');
        });
        
        // Close when clicking outside
        document.addEventListener('click', function(event) {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenuButton.setAttribute('aria-expanded', 'false');
                userMenu.classList.add('hidden');
            }
        });
    }
});
