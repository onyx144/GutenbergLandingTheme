<?php
/**
 * Callback-функция для полей Pop-up.
 */

// Инициализируем настройки Pop-up
function template_theme_register_popup_settings_multilang_tabs() {
    register_setting(
        'template_theme_popup_settings_group',
        'template_theme_popup_options',
        'template_theme_sanitize_popup_options_multilang_tabs'
    );

    add_settings_section(
        'template_theme_popup_main_section',
        'Настройки popup',
        '',
        'popup_settings'
    );

    $languages = ['uk' => 'Українська', 'en' => 'English', 'es' => 'Español'];

    foreach ($languages as $lang => $lang_name) {
        add_settings_field(
            'popup_image_' . $lang,
            sprintf(__('Изображение (%s):', 'template_theme'), $lang_name),
            'template_theme_render_field_image',
            'popup_settings',
            'template_theme_popup_main_section',
            ['lang' => $lang]
        );
        add_settings_field(
            'popup_title_' . $lang,
            sprintf(__('Заголовок (%s):', 'template_theme'), $lang_name),
            'template_theme_render_field_text',
            'popup_settings',
            'template_theme_popup_main_section',
            ['lang' => $lang]
        );
        add_settings_field(
            'popup_text_' . $lang,
            sprintf(__('Текст (%s):', 'template_theme'), $lang_name),
            'template_theme_render_field_textarea',
            'popup_settings',
            'template_theme_popup_main_section',
            ['lang' => $lang]
        );
        add_settings_field(
            'popup_button_text_' . $lang,
            sprintf(__('Текст кнопки (%s):', 'template_theme'), $lang_name),
            'template_theme_render_field_text',
            'popup_settings',
            'template_theme_popup_main_section',
            ['lang' => $lang]
        );
        add_settings_field(
            'popup_button_link_' . $lang,
            sprintf(__('Ссылка кнопки (%s):', 'template_theme'), $lang_name),
            'template_theme_render_field_text',
            'popup_settings',
            'template_theme_popup_main_section',
            ['lang' => $lang]
        );
        add_settings_field(
            'popup_condition_' . $lang,
            sprintf(__('Условие показа (%s):', 'template_theme'), $lang_name),
            'template_theme_render_field_select_condition',
            'popup_settings',
            'template_theme_popup_main_section',
            ['lang' => $lang]
        );
        add_settings_field(
            'popup_condition_value_' . $lang,
            sprintf(__('Значение условия (%s):', 'template_theme'), $lang_name),
            'template_theme_render_field_number',
            'popup_settings',
            'template_theme_popup_main_section',
            ['lang' => $lang]
        );
    }
}
add_action('admin_init', 'template_theme_register_popup_settings_multilang_tabs');


/**
 * Функция очистки данных перед сохранением для мультиязычности (вкладки).
 */
function template_theme_sanitize_popup_options_multilang_tabs($input) {
    $sanitized = array();
    $languages = ['uk', 'en', 'es'];

    foreach ($languages as $lang) {
        if (isset($input['popup_image_' . $lang])) {
            $sanitized['popup_image_' . $lang] = esc_url_raw($input['popup_image_' . $lang]);
        }
        if (isset($input['popup_title_' . $lang])) {
            $sanitized['popup_title_' . $lang] = sanitize_text_field($input['popup_title_' . $lang]);
        }
        if (isset($input['popup_text_' . $lang])) {
            $sanitized['popup_text_' . $lang] = sanitize_textarea_field($input['popup_text_' . $lang]);
        }
        if (isset($input['popup_button_text_' . $lang])) {
            $sanitized['popup_button_text_' . $lang] = sanitize_text_field($input['popup_button_text_' . $lang]);
        }
        if (isset($input['popup_button_link_' . $lang])) {
            $sanitized['popup_button_link_' . $lang] = esc_url_raw($input['popup_button_link_' . $lang]);
        }
        if (isset($input['popup_condition_' . $lang])) {
            $sanitized['popup_condition_' . $lang] = sanitize_text_field($input['popup_condition_' . $lang]);
        }
        if (isset($input['popup_condition_value_' . $lang])) {
            $sanitized['popup_condition_value_' . $lang] = intval($input['popup_condition_value_' . $lang]);
        }
    }

    return $sanitized;
}

// Callback-функции для отрисовки полей


// callback функция для полей попапа
function template_theme_popup_fields_callback() {
    include_once(get_template_directory() . '/inc/settings/popup-page.php');
}