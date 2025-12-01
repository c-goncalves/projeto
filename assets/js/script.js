document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.getElementById('menu-button');
    const navLinks = document.getElementById('main-nav-links');

    if (menuButton && navLinks) {
        
        const isDesktop = window.matchMedia('(min-width: 768px)');
        menuButton.addEventListener('click', function() {
            navLinks.classList.toggle('hidden'); 
        });
        function handleResize() {
            if (isDesktop.matches) {
                navLinks.classList.remove('hidden'); 
            } else {
                if (!navLinks.classList.contains('hidden')) {
                     navLinks.classList.add('hidden');
                }
            }
        }
        
        window.addEventListener('resize', handleResize);
        
        handleResize();
    }
});