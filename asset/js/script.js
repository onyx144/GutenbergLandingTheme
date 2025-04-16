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
jQuery(document).ready(function($) {
    $('.language-dropdown .current-lang-button').on('click', function() {
        $('.language-dropdown .lang-dropdown-list').toggleClass('show');
    });

    // Закрывать выпадающий список при клике вне его
    $(document).on('click', function(event) {
        if (!$(event.target).closest('.language-dropdown').length) {
            $('.language-dropdown .lang-dropdown-list').removeClass('show');
        }
    });
});