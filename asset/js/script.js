document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const menu = document.querySelector('.main-navigation ul');

    if (menuToggle && menu) {
        menuToggle.addEventListener('click', function() {
            console.log('test');
            menu.classList.toggle('show');
        });
    }
});