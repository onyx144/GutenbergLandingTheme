<?php
/**
 * Callback-функция для полей Pop-up.
 */

// Инициализируем настройки Pop-up
$popup_options = get_option('template_theme_popup_options');
$popup = isset($popup_options) ? $popup_options : array();

/**
 * Функция очистки данных перед сохранением.
 */
function template_theme_sanitize_popup_options($input) {
    $sanitized = array();

    if (isset($input)) {
        $sanitized = array(
            'popup_image' => esc_url_raw($input['popup_image']),
            'popup_title' => sanitize_text_field($input['popup_title']),
            'popup_text' => sanitize_textarea_field($input['popup_text']),
            'popup_button_text' => sanitize_text_field($input['popup_button_text']),
            'popup_button_link' => sanitize_text_field($input['popup_button_link']),
            'popup_condition' => sanitize_text_field($input['popup_condition']),
            'popup_condition_value' => intval($input['popup_condition_value'])
        );
    }
    return $sanitized;
}

// Регистрируем настройки Pop-up
function template_theme_register_popup_settings() {
    register_setting(
        'template_theme_popup_settings_group',
        'template_theme_popup_options',
        'template_theme_sanitize_popup_options'
    );

    add_settings_section(
        'template_theme_popup_main_section',
        'Настройки Pop-up',
        '',
        'template_theme_settings' // slug вашей страницы настроек
    );

    add_settings_field(
        'template_theme_popup_fields',
        'Настройки Pop-up',
        'template_theme_popup_fields_callback',
        'template_theme_settings',
        'template_theme_popup_main_section'
    );
}
add_action('admin_init', 'template_theme_register_popup_settings');

// callback функция для полей попапа
function template_theme_popup_fields_callback() {
    // Вывод формы настроек Pop-up
    include_once(get_template_directory() . '/inc/settings/popup-page.php');
}

?>