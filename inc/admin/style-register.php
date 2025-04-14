<?php
// ... (другой код) ...

/**
 * Регистрация настроек стилей.
 */
function template_theme_register_style_settings() {
    register_setting(
        'template_theme_style_settings_group',
        'template_theme_style_options',
        'template_theme_sanitize_style_options'
    );

    add_settings_section(
        'template_theme_style_main_section',
        'Настройки стилей',
        '',
        'style_settings'
    );

    add_settings_field(
        'template_theme_style_fields',
        'Настройки стилей',
        'template_theme_style_fields_callback',
        'style_settings',
        'template_theme_style_main_section'
    );
}
add_action('admin_init', 'template_theme_register_style_settings');

/**
 * Callback-функция для полей стилей.
 */
function template_theme_style_fields_callback() {
    include_once(get_template_directory() . '/inc/settings/style-settings.php');
}

/**
 * Функция очистки данных стилей.
 */
function template_theme_sanitize_style_options($input) {
    $sanitized = array();

    if (isset($input['site_background_color'])) {
        $sanitized['site_background_color'] = sanitize_hex_color($input['site_background_color']);
    }

    if (isset($input['site_font_family'])) {
        $sanitized['site_font_family'] = sanitize_text_field($input['site_font_family']);
    }

    if (isset($input['site_font_color'])) {
        $sanitized['site_font_color'] = sanitize_hex_color($input['site_font_color']);
    }

    if (isset($input['site_font_size'])) {
        $sanitized['site_font_size'] = intval($input['site_font_size']);
    }

    if (isset($input['table_style'])) {
        $sanitized['table_style'] = sanitize_textarea_field($input['table_style']);
    }

    if (isset($input['heading_default_color'])) {
        $sanitized['heading_default_color'] = sanitize_hex_color($input['heading_default_color']);
    }

    if (isset($input['h1_color'])) {
        $sanitized['h1_color'] = sanitize_hex_color($input['h1_color']);
    }

    if (isset($input['h2_color'])) {
        $sanitized['h2_color'] = sanitize_hex_color($input['h2_color']);
    }

    if (isset($input['p_color'])) {
        $sanitized['p_color'] = sanitize_hex_color($input['p_color']);
    }

    if (isset($input['a_color'])) {
        $sanitized['a_color'] = sanitize_hex_color($input['a_color']);
    }
    return $sanitized;
}
?>