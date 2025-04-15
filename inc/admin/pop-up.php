<?php
/**
 * Callback-функция для полей Pop-up.
 */

// Инициализируем настройки Pop-up
function template_theme_register_popup_settings() {
    register_setting(
        'template_theme_popup_settings_group',
        'template_theme_popup_options',
        'template_theme_sanitize_popup_options'
    );

    add_settings_section(
        'template_theme_popup_main_section',
        'Настройки popup',
        '',
        'popup_settings'
    );

    add_settings_field(
        'template_theme_popup_fields',
        'Настройки popup',
        'template_theme_popup_fields_callback',
        'popup_settings',
        'template_theme_popup_main_section'
    );
}
add_action('admin_init', 'template_theme_register_popup_settings');


/**
 * Функция очистки данных перед сохранением.
 */
function template_theme_sanitize_popup_options($input) {
    $sanitized = array();

    if (isset($input['popup_image'])) {
        $sanitized['popup_image'] = esc_url_raw($input['popup_image']);
    }

    if (isset($input['popup_title'])) {
        $sanitized['popup_title'] = sanitize_text_field($input['popup_title']);
    }

    if (isset($input['popup_text'])) {
        $sanitized['popup_text'] = sanitize_textarea_field($input['popup_text']);
    }

    if (isset($input['popup_button_text'])) {
        $sanitized['popup_button_text'] = sanitize_text_field($input['popup_button_text']);
    }

    if (isset($input['popup_button_link'])) {
        $sanitized['popup_button_link'] = esc_url_raw($input['popup_button_link']);
    }

    if (isset($input['popup_condition'])) {
        $sanitized['popup_condition'] = sanitize_text_field($input['popup_condition']);
    }

    if (isset($input['popup_condition_value'])) {
        $sanitized['popup_condition_value'] = intval($input['popup_condition_value']);
    }

    return $sanitized;
}

// ... (другой код) ...


// callback функция для полей попапа
function template_theme_popup_fields_callback() {
    // Вывод формы настроек Pop-up
    include_once(get_template_directory() . '/inc/settings/popup-page.php');
}

?>