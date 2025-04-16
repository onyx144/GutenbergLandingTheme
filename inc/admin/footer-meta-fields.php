<?php
/**
 * Регистрирует настройки и поля для настроек футера.
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Регистрирует настройки для футера и добавляет секцию и поля.
 */
function template_theme_register_footer_settings() {
    register_setting(
        'template_theme_footer_settings_group',
        'template_theme_footer_options',
        'template_theme_sanitize_footer_options'
    );

    add_settings_section(
        'template_theme_footer_main_section',
        'Настройки футера',
        '',
        'footer_settings'
    );

    for ($i = 1; $i <= 4; $i++) {
        add_settings_field(
            'footer_icon_' . $i,
            sprintf(__('Иконка %d (URL):', 'template_theme'), $i),
            'template_theme_render_field_image',
            'footer_settings',
            'template_theme_footer_main_section',
            ['id' => 'footer_icon_' . $i]
        );
        add_settings_field(
            'footer_link_' . $i,
            sprintf(__('Ссылка %d:', 'template_theme'), $i),
            'template_theme_render_field_text',
            'footer_settings',
            'template_theme_footer_main_section',
            ['id' => 'footer_link_' . $i]
        );
    }

    add_settings_field(
        'footer_copyright_text',
        __('Текст копирайта:', 'template_theme'),
        'template_theme_render_field_textarea',
        'footer_settings',
        'template_theme_footer_main_section',
        ['id' => 'footer_copyright_text']
    );
}
add_action('admin_init', 'template_theme_register_footer_settings');

/**
 * Функция очистки данных перед сохранением для настроек футера.
 */
function template_theme_sanitize_footer_options($input) {
    $sanitized = array();

    for ($i = 1; $i <= 4; $i++) {
        $sanitized['footer_icon_' . $i] = isset($input['footer_icon_' . $i]) ? esc_url_raw($input['footer_icon_' . $i]) : '';
        $sanitized['footer_link_' . $i] = isset($input['footer_link_' . $i]) ? esc_url_raw($input['footer_link_' . $i]) : '';
    }

    $sanitized['footer_copyright_text'] = isset($input['footer_copyright_text']) ? sanitize_textarea_field($input['footer_copyright_text']) : '';

    return $sanitized;
}