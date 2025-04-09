<?php
/**
 * Header Settings API - Регистрация настроек, секций и полей для вкладки "Хедер"
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Защита от прямого доступа

/**
 * Инициализация настроек темы (Регистрация настроек хедера).
 * Срабатывает при загрузке админ-панели.
 */
function template_theme_settings_init() {
    // 1. Регистрация самой опции (массива настроек) в базе данных
    register_setting(
        'template_theme_header_settings_group', // Название группы настроек
        'template_theme_header_options',        // Название опции в базе данных wp_options
        'template_theme_sanitize_header_options' // Функция для очистки данных
    );

    // 2. Добавление секций на страницу настроек
    add_settings_section(
        'template_theme_header_logo_section',
        __( 'Логотип', 'template_theme' ),
        'template_theme_header_logo_section_callback',
        'template_theme_settings' // Slug страницы настроек
    );

    add_settings_section(
        'template_theme_header_menu_section',
        __( 'Навигация (Меню)', 'template_theme' ),
        'template_theme_header_menu_section_callback',
        'template_theme_settings'
    );

    add_settings_section(
        'template_theme_header_lang_section',
        __( 'Переключатель языка', 'template_theme' ),
        'template_theme_header_lang_section_callback',
        'template_theme_settings'
    );

    add_settings_section(
        'template_theme_header_auth_buttons_section',
        __( 'Кнопки Вход/Регистрация', 'template_theme' ),
        null,
        'template_theme_settings'
    );


    // 3. Добавление полей настроек в секции
    add_settings_field(
        'show_language_switcher',
        __( 'Показывать переключатель?', 'template_theme' ),
        'template_theme_render_field_checkbox',
        'template_theme_settings',
        'template_theme_header_lang_section',
        [
            'option_name' => 'template_theme_header_options',
            'field_id'    => 'show_language_switcher',
            'label_for'   => 'show_language_switcher',
            'description' => __( 'Отметьте, чтобы отображать переключатель языка (требуется совместимый плагин, например, WPML или Polylang). Тема предоставляет только место для его вывода.', 'template_theme')
        ]
    );

    add_settings_field(
        'show_auth_buttons',
        __( 'Показывать кнопки?', 'template_theme' ),
        'template_theme_render_field_checkbox',
        'template_theme_settings',
        'template_theme_header_auth_buttons_section',
        [
            'option_name' => 'template_theme_header_options',
            'field_id'    => 'show_auth_buttons',
            'label_for'   => 'show_auth_buttons'
        ]
    );

    add_settings_field(
        'login_button_text',
        __( 'Текст кнопки "Вход"', 'template_theme' ),
        'template_theme_render_field_text',
        'template_theme_settings',
        'template_theme_header_auth_buttons_section',
        [
            'option_name' => 'template_theme_header_options',
            'field_id'    => 'login_button_text',
            'label_for'   => 'login_button_text',
            'default'     => __( 'Вход', 'template_theme' )
        ]
    );

    add_settings_field(
        'login_button_url',
        __( 'URL кнопки "Вход"', 'template_theme' ),
        'template_theme_render_field_url',
        'template_theme_settings',
        'template_theme_header_auth_buttons_section',
        [
            'option_name' => 'template_theme_header_options',
            'field_id'    => 'login_button_url',
            'label_for'   => 'login_button_url'
        ]
    );

     add_settings_field(
        'register_button_text',
        __( 'Текст кнопки "Регистрация"', 'template_theme' ),
        'template_theme_render_field_text',
        'template_theme_settings',
        'template_theme_header_auth_buttons_section',
        [
            'option_name' => 'template_theme_header_options',
            'field_id'    => 'register_button_text',
            'label_for'   => 'register_button_text',
            'default'     => __( 'Регистрация', 'template_theme' )
        ]
    );

    add_settings_field(
        'register_button_url',
        __( 'URL кнопки "Регистрация"', 'template_theme' ),
        'template_theme_render_field_url',
        'template_theme_settings',
        'template_theme_header_auth_buttons_section',
        [
            'option_name' => 'template_theme_header_options',
            'field_id'    => 'register_button_url',
            'label_for'   => 'register_button_url'
        ]
    );
}
// Регистрируем функцию на хук admin_init
add_action( 'admin_init', 'template_theme_settings_init' );

/**
 * Callback-функции для описания секций
 */
function template_theme_header_logo_section_callback() {
    $customize_url = admin_url( 'customize.php?autofocus[section]=title_tagline' );
    printf(
        __( 'Настройки логотипа управляются через стандартный <a href="%s">Кастомайзер WordPress</a> (Внешний вид -> Настроить -> Свойства сайта). Тема будет адаптировать размер логотипа под область хедера.', 'template_theme' ),
        esc_url( $customize_url )
    );
}

function template_theme_header_menu_section_callback() {
    $menus_url = admin_url( 'nav-menus.php' );
    printf(
        __( 'Меню настраивается в разделе <a href="%s">Внешний вид -> Меню</a>. Выберите или создайте меню и назначьте его для области "Primary Menu".', 'template_theme' ),
        esc_url( $menus_url )
    );
}
function template_theme_header_lang_section_callback() {
     esc_html_e( 'Настройки для отображения переключателя языка.', 'template_theme' );
}


/**
 * Callback-функции для отрисовки полей настроек
 */
function template_theme_render_field_text( $args ) {
    $options = get_option( $args['option_name'] );
    $value = isset( $options[ $args['field_id'] ] ) ? $options[ $args['field_id'] ] : (isset($args['default']) ? $args['default'] : '');
    $description = isset($args['description']) ? '<p class="description">' . esc_html($args['description']) . '</p>' : '';
    printf(
        '<input type="text" id="%s" name="%s[%s]" value="%s" class="regular-text" />%s',
        esc_attr( $args['label_for'] ),
        esc_attr( $args['option_name'] ),
        esc_attr( $args['field_id'] ),
        esc_attr( $value ),
        $description
    );
}

function template_theme_render_field_url( $args ) {
    $options = get_option( $args['option_name'] );
    $value = isset( $options[ $args['field_id'] ] ) ? $options[ $args['field_id'] ] : '';
    $description = isset($args['description']) ? '<p class="description">' . esc_html($args['description']) . '</p>' : '';
    printf(
        '<input type="url" id="%s" name="%s[%s]" value="%s" class="regular-text" placeholder="https://" />%s',
        esc_attr( $args['label_for'] ),
        esc_attr( $args['option_name'] ),
        esc_attr( $args['field_id'] ),
        esc_attr( $value ),
        $description
    );
}

function template_theme_render_field_checkbox( $args ) {
    $options = get_option( $args['option_name'] );
    $checked = isset( $options[ $args['field_id'] ] ) ? $options[ $args['field_id'] ] : '0';
    $description = isset($args['description']) ? '<p class="description">' . esc_html($args['description']) . '</p>' : '';
    printf(
        '<input type="checkbox" id="%s" name="%s[%s]" value="1" %s />%s',
        esc_attr( $args['label_for'] ),
        esc_attr( $args['option_name'] ),
        esc_attr( $args['field_id'] ),
        checked( '1', $checked, false ),
        $description
    );
}

/**
 * Функция очистки (санитизации) данных перед сохранением в БД.
 */
function template_theme_sanitize_header_options( $input ) {
    $sanitized_input = array();
    $checkboxes = ['show_language_switcher', 'show_auth_buttons'];
    foreach ($checkboxes as $cb) {
        if ( ! empty( $input[$cb] ) ) {
            $sanitized_input[$cb] = '1';
        }
    }
    $text_fields = ['login_button_text', 'register_button_text'];
    foreach ($text_fields as $tf) {
         if ( isset( $input[$tf] ) ) {
            $sanitized_input[$tf] = sanitize_text_field( $input[$tf] );
        }
    }
     $url_fields = ['login_button_url', 'register_button_url'];
     foreach ($url_fields as $uf) {
         if ( isset( $input[$uf] ) ) {
            $sanitized_input[$uf] = esc_url_raw( $input[$uf] );
        }
     }
    return $sanitized_input;
}

?>