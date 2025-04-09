<?php
/**
 * Page Options API - Регистрация настроек, секций и полей для опций страниц.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Защита от прямого доступа

/**
 * Инициализация опций страниц.
 */
function template_theme_page_options_init() {
    // 1. Регистрация опции для баннера
    register_setting(
        'template_theme_banner_options_group',
        'template_theme_banner_options',
        'template_theme_sanitize_banner_options'
    );

    // 2. Добавление секций на страницу настроек
    add_settings_section(
        'template_theme_banner_settings_section',
        __( 'Настройки баннера', 'template_theme' ),
        'template_theme_banner_settings_section_callback',
        'template_theme_page_options' // Slug страницы настроек
    );

    // 3. Добавление полей настроек в секции
    add_settings_field(
        'banner_mobile',
        __( 'Мобильный баннер', 'template_theme' ),
        'template_theme_render_field',
        'template_theme_page_options',
        'template_theme_banner_settings_section',
        [
            'option_name' => 'template_theme_banner_options',
            'field_id'    => 'banner_mobile',
            'label_for'   => 'banner_mobile',
            'type'        => 'image' // Тип поля
        ]
    );

    add_settings_field(
        'banner_desktop',
        __( 'Десктоп баннер', 'template_theme' ),
        'template_theme_render_field',
        'template_theme_page_options',
        'template_theme_banner_settings_section',
        [
            'option_name' => 'template_theme_banner_options',
            'field_id'    => 'banner_desktop',
            'label_for'   => 'banner_desktop',
            'type'        => 'image' // Тип поля
        ]
    );

    add_settings_field(
        'show_banner_main_page',
        __( 'Показывать баннер на главной странице', 'template_theme' ),
        'template_theme_render_field',
        'template_theme_page_options',
        'template_theme_banner_settings_section',
        [
            'option_name' => 'template_theme_banner_options',
            'field_id'    => 'show_banner_main_page',
            'label_for'   => 'show_banner_main_page',
            'type'        => 'checkbox' // Тип поля
        ]
    );

    add_settings_field(
        'show_banner_pages',
        __( 'Показывать баннер на страницах', 'template_theme' ),
        'template_theme_render_field',
        'template_theme_page_options',
        'template_theme_banner_settings_section',
        [
            'option_name' => 'template_theme_banner_options',
            'field_id'    => 'show_banner_pages',
            'label_for'   => 'show_banner_pages',
            'type'        => 'checkbox' // Тип поля
        ]
    );

    add_settings_field(
        'show_banner_categories',
        __( 'Показывать баннер на категориях', 'template_theme' ),
        'template_theme_render_field',
        'template_theme_page_options',
        'template_theme_banner_settings_section',
        [
            'option_name' => 'template_theme_banner_options',
            'field_id'    => 'show_banner_categories',
            'label_for'   => 'show_banner_categories',
            'type'        => 'checkbox' // Тип поля
        ]
    );

    add_settings_field(
        'favicon',
        __( 'Фавикон', 'template_theme' ),
        'template_theme_render_field',
        'template_theme_page_options',
        'template_theme_banner_settings_section',
        [
            'option_name' => 'template_theme_banner_options',
            'field_id'    => 'favicon',
            'label_for'   => 'favicon',
            'type'        => 'image' // Тип поля
        ]
    );
}
add_action( 'admin_init', 'template_theme_page_options_init' );

/**
 * Callback-функция для описания секции баннера.
 */
function template_theme_banner_settings_section_callback() {
    esc_html_e( 'Настройки баннера для всего сайта.', 'template_theme' );
}

/**
 * Функция очистки (санитизации) данных перед сохранением в БД.
 */
function template_theme_sanitize_banner_options( $input ) {
    $sanitized_input = array();
    $sanitized_input['banner_mobile'] = isset( $input['banner_mobile'] ) ? esc_url_raw( $input['banner_mobile'] ) : '';
    $sanitized_input['banner_desktop'] = isset( $input['banner_desktop'] ) ? esc_url_raw( $input['banner_desktop'] ) : '';
    $sanitized_input['show_banner_main_page'] = isset( $input['show_banner_main_page'] ) ? '1' : '0';
    $sanitized_input['show_banner_pages'] = isset( $input['show_banner_pages'] ) ? '1' : '0';
    $sanitized_input['show_banner_categories'] = isset( $input['show_banner_categories'] ) ? '1' : '0';
    $sanitized_input['favicon'] = isset( $input['favicon'] ) ? esc_url_raw( $input['favicon'] ) : '';
    return $sanitized_input;
}
?>