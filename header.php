<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package template_theme
 */

// Получаем массив сохраненных опций хедера
$header_options = get_option( 'template_theme_header_options' );

// Устанавливаем значения по умолчанию, если опции еще не сохранены или отсутствуют
$show_language_switcher = $header_options['show_language_switcher'] ?? '0'; // '0' или '1'
$show_auth_buttons      = $header_options['show_auth_buttons'] ?? '0';        // '0' или '1'
$login_button_text      = $header_options['login_button_text'] ?? __( 'Вход', 'template_theme' );
$login_button_url       = $header_options['login_button_url'] ?? wp_login_url(); // URL по умолчанию - страница входа WP
$register_button_text   = $header_options['register_button_text'] ?? __( 'Регистрация', 'template_theme' );
$register_button_url    = $header_options['register_button_url'] ?? wp_registration_url(); // URL по умолчанию - страница регистрации WP (если разрешена)

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'template_theme' ); ?></a>

    <header id="masthead" class="site-header">
        <div class="site-branding">
            <?php
            // Вывод логотипа (управляется через Кастомайзер)
            the_custom_logo();
            // Вывод названия и описания сайта (если логотип не установлен)
            if ( ! has_custom_logo() ) { // Показываем только если нет лого
                if ( is_front_page() && is_home() ) :
                    ?>
                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <?php
                else :
                    ?>
                    <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                    <?php
                endif;
                $template_theme_description = get_bloginfo( 'description', 'display' );
                if ( $template_theme_description || is_customize_preview() ) :
                    ?>
                    <p class="site-description"><?php echo esc_html( $template_theme_description ); ?></p>
                <?php endif;
            } // end if ! has_custom_logo ?>
        </div>
        <?php // --- Область для переключателя языка и кнопок --- ?>
        <div class="header-controls">

            <?php // --- Переключатель языка ---
            if ( $show_language_switcher === '1' ) : ?>
                <div class="language-switcher-area">
                    <?php
                    // Здесь нужно вставить код или хук вашего плагина для переключения языков.
                    // Например, для WPML это может быть: do_action('wpml_add_language_selector');
                    // Или для Polylang: if ( function_exists('pll_the_languages') ) { pll_the_languages( array( 'dropdown' => 1 ) ); }
                    // Пока оставим комментарий-заглушку:
                    echo '';
                    ?>
                </div><?php endif; ?>


            <?php // --- Кнопки Вход/Регистрация ---
            if ( $show_auth_buttons === '44' ) : ?>
                <div class="auth-buttons">
                    <?php if ( ! is_user_logged_in() ) : // Показываем только неавторизованным пользователям ?>
                        <?php if ( ! empty( $login_button_text ) && ! empty( $login_button_url ) ) : ?>
                            <a href="<?php echo esc_url( $login_button_url ); ?>" class="button button-login">
                                <?php echo esc_html( $login_button_text ); ?>
                            </a>
                        <?php endif; ?>

                        <?php
                        // Показываем кнопку регистрации только если регистрация разрешена в настройках WP
                     
                            if ( ! empty( $register_button_text ) && ! empty( $register_button_url ) ) : ?>
                                <a href="<?php echo esc_url( $register_button_url ); ?>" class="button button-register">
                                    <?php echo esc_html( $register_button_text ); ?>
                                </a>
                            <?php endif;
                        ?>
                    <?php else : // Если пользователь авторизован, можно показать кнопку выхода или ссылку на профиль ?>
                        <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="button button-logout">
                            <?php esc_html_e( 'Выход', 'template_theme' ); ?>
                        </a>
                        <?php // Или ссылка на профиль:
                        // $current_user = wp_get_current_user();
                        // echo '<a href="' . esc_url(get_edit_user_link($current_user->ID)) . '">' . esc_html($current_user->display_name) . '</a>';
                        ?>
                    <?php endif; // is_user_logged_in() ?>
                </div><?php endif; // $show_auth_buttons ?>

        </div><?php // --- Конец области для переключателя языка и кнопок --- ?>


        <nav id="site-navigation" class="main-navigation">
            <?php // Кнопка "Бургер" для мобильного меню (потребуется CSS/JS для работы) ?>
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <span class="dashicons dashicons-menu"></span> <?php // Используем Dashicon для иконки ?>
                <span class="screen-reader-text"><?php esc_html_e( 'Меню', 'template_theme' ); ?></span>
            </button>
            <?php
            // Вывод основного меню (управляется через Внешний вид -> Меню)
            function template_theme_add_auth_buttons_to_menu( $items, $args ) {
                // Получаем опции хедера
                $header_options = get_option( 'template_theme_header_options' );
                $show_auth_buttons = $header_options['show_auth_buttons'] ?? '0';
                $login_button_text = $header_options['login_button_text'] ?? __( 'Вход', 'template_theme' );
                $login_button_url = $header_options['login_button_url'] ?? wp_login_url();
                $register_button_text = $header_options['register_button_text'] ?? __( 'Регистрация', 'template_theme' );
                $register_button_url = $header_options['register_button_url'] ?? wp_registration_url();
            
                if ( $show_auth_buttons === '1' && $args->theme_location === 'primary' ) {
                    if ( ! is_user_logged_in() ) {
                        $login_button = '<li class="menu-item menu-item-button"><a href="' . esc_url( $login_button_url ) . '" class="button button-login">' . esc_html( $login_button_text ) . '</a></li>';
                        $register_button = '';
                            $register_button = '<li class="menu-item menu-item-button"><a href="' . esc_url( $register_button_url ) . '" class="button button-register">' . esc_html( $register_button_text ) . '</a></li>';
                        
                        $items .= $login_button . $register_button;
                    } 
                }
                return $items;
            }
            add_filter( 'wp_nav_menu_items', 'template_theme_add_auth_buttons_to_menu', 10, 2 );
            wp_nav_menu(
                array(
                    'theme_location' => 'primary', // ID области меню
                    'menu_id'        => 'primary-menu',
                    'container_class' => 'primary-menu-container', // Добавляем класс для контейнера меню (для скрытия на мобильных)
                )
            );
            ?>
            
        </nav>
    </header>

    <div id="content" class="site-content">
        <?php // Основной контент страницы начнется здесь ?>