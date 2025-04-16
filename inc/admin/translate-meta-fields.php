<?php
/**
 * Регистрирует метаполя для переводов.
 */
if (!defined('ABSPATH')) {
    exit;
}
function template_theme_translate_settings_page() {
    add_submenu_page(
        'themes.php', // Parent slug
        __('Translate', 'template_theme'), // Page title
        __('Translate', 'template_theme'), // Menu title
        'manage_options', // Capability
        'template_theme_translate_settings', // Menu slug
        'template_theme_render_translate_settings_page' // Callback function
    );
}
add_action('admin_menu', 'template_theme_translate_settings_page');

function template_theme_register_translate_settings() {
    register_setting(
        'template_theme_translate_settings_group',
        'template_theme_translate_options'
    );
}
add_action('admin_init', 'template_theme_register_translate_settings');

function template_theme_register_translate_meta_fields() {
    $prefix = 'translate_'; // Префикс для метаполей

    // Кнопка "Войти"
    register_post_meta(
        '', // Применяется ко всем типам записей
        $prefix . 'button_login_uk',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'button_login_en',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'button_login_es',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'button_login_link_uk',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'button_login_link_en',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'button_login_link_es',
        ['type' => 'string', 'show_admin_column' => false]
    );

    // Кнопка "Регистрация"
    register_post_meta(
        '',
        $prefix . 'button_registration_uk',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'button_registration_en',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'button_registration_es',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'button_registration_link_uk',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'button_registration_link_en',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'button_registration_link_es',
        ['type' => 'string', 'show_admin_column' => false]
    );

    // Заголовок 404
    register_post_meta(
        '',
        $prefix . 'title_404_uk',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'title_404_en',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'title_404_es',
        ['type' => 'string', 'show_admin_column' => false]
    );

    // Кнопка "На главную" 404
    register_post_meta(
        '',
        $prefix . 'button_home_404_uk',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'button_home_404_en',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'button_home_404_es',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'button_home_404_link', // Ссылка на главную обычно одна
        ['type' => 'string', 'show_admin_column' => false]
    );

    // Текст уведомления 404
    register_post_meta(
        '',
        $prefix . 'text_404_uk',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'text_404_en',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'text_404_es',
        ['type' => 'string', 'show_admin_column' => false]
    );

    // Фоновая картинка 404
    register_post_meta(
        '',
        $prefix . 'bg_image_404_uk',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'bg_image_404_en',
        ['type' => 'string', 'show_admin_column' => false]
    );
    register_post_meta(
        '',
        $prefix . 'bg_image_404_es',
        ['type' => 'string', 'show_admin_column' => false]
    );
}
add_action('init', 'template_theme_register_translate_meta_fields');