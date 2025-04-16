<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 *
 * @package template_theme
 */

// Получаем массив сохраненных опций хедера
$header_options = get_option( 'template_theme_header_options' );
$post_id = get_the_ID();

// Устанавливаем значения по умолчанию, если опции еще не сохранены или отсутствуют
$show_language_switcher = $header_options['show_language_switcher'] ?? '0'; // '0' или '1'
$show_auth_buttons      = $header_options['show_auth_buttons'] ?? '0';        // '0' или '1'
$login_button_text      = $header_options['login_button_text'] ?? __( 'Вход', 'template_theme' );
$login_button_url       = $header_options['login_button_url'] ?? wp_login_url(); // URL по умолчанию - страница входа WP
$register_button_text   = $header_options['register_button_text'] ?? __( 'Регистрация', 'template_theme' );
$register_button_url    = $header_options['register_button_url'] ?? wp_registration_url(); // URL по умолчанию - страница регистрации WP (если разрешена)
$banner_mobile_local = get_post_meta($post_id, 'banner_mobile', true);
$banner_desktop_local = get_post_meta($post_id, 'banner_desktop', true);
$banner_title = get_post_meta($post_id, 'banner_title', true);
$banner_text = get_post_meta($post_id, 'banner_text', true);
$button_text = get_post_meta($post_id, 'button_text', true);
$button_url = get_post_meta($post_id, 'button_url', true);
$banner_options_global = get_option('template_theme_banner_options');
$banner_mobile_global = isset($banner_options_global['banner_mobile']) ? $banner_options_global['banner_mobile'] : '';
$banner_desktop_global = isset($banner_options_global['banner_desktop']) ? $banner_options_global['banner_desktop'] : '';
$banner_title_global = isset($banner_options_global['banner_title']) ? $banner_options_global['banner_title'] : '';
$banner_text_global = isset($banner_options_global['banner_text']) ? $banner_options_global['banner_text'] : '';
$button_text_global = isset($banner_options_global['button_text']) ? $banner_options_global['button_text'] : '';
$button_url_global = isset($banner_options_global['button_url']) ? $banner_options_global['button_url'] : '';
$show_banner_main_page = isset($banner_options_global['show_banner_main_page']) ? (bool) $banner_options_global['show_banner_main_page'] : false;
$show_banner_pages = isset($banner_options_global['show_banner_pages']) ? (bool) $banner_options_global['show_banner_pages'] : false;
$show_banner_categories = isset($banner_options_global['show_banner_categories']) ? (bool) $banner_options_global['show_banner_categories'] : false;

// Определяем, нужно ли выводить баннер и какие данные использовать
$show_banner = false;
$banner_image = '';

$options = get_option('custom_blocks_options');
$popup = isset($options['popup']) ? $options['popup'] : array();
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <style>
    body {
        background-color: <?php echo esc_attr(get_option('template_theme_style_options')['site_background_color']); ?>;
        font-family: <?php echo esc_attr(get_option('template_theme_style_options')['site_font_family']); ?>;
        color: <?php echo esc_attr(get_option('template_theme_style_options')['site_font_color']); ?>;
        font-size: <?php echo esc_attr(get_option('template_theme_style_options')['site_font_size']); ?>px;
    }

    table {
        <?php echo esc_attr(get_option('template_theme_style_options')['table_style']); ?>
    }

    h1, h2, h3, h4, h5, h6, p {
        color: <?php echo esc_attr(get_option('template_theme_style_options')['heading_default_color']); ?>;
    }

    h1 {
        color: <?php echo esc_attr(get_option('template_theme_style_options')['h1_color'] ?: get_option('template_theme_style_options')['heading_default_color']); ?>;
    }

    h2 {
        color: <?php echo esc_attr(get_option('template_theme_style_options')['h2_color'] ?: get_option('template_theme_style_options')['heading_default_color']); ?>;
    }

    p {
        color: <?php echo esc_attr(get_option('template_theme_style_options')['p_color'] ?: get_option('template_theme_style_options')['heading_default_color']); ?>;
    }
    a {
        color: <?php echo esc_attr(get_option('template_theme_style_options')['a_color']); ?>;
    }

</style>
    <script>
    jQuery(document).ready(function($) {
        var popup = $('#custom_popup');
        var condition = '<?php echo esc_js($popup['condition']); ?>';
        var conditionValue = '<?php echo esc_js($popup['condition_value']); ?>';

        function showPopup() {
            popup.fadeIn();
        }

        function hidePopup() {
            popup.fadeOut();
        }

        $('.close_popup').click(hidePopup);

        switch (condition) {
            case 'timer':
                setTimeout(showPopup, conditionValue * 1000);
                break;
            case 'scroll':
                $(window).scroll(function() {
                    if ($(window).scrollTop() > $(document).height() * conditionValue / 100) {
                        showPopup();
                        $(window).off('scroll');
                    }
                });
                break;
            case 'pages':
                // Логика для показа Pop-up при переходах по страницам
                // (требует дополнительной реализации)
                break;
            case 'wait':
                setTimeout(showPopup, conditionValue * 1000);
                break;
            default:
                break;
        }
    });
</script>
    <?php wp_head(); ?>
    <div id="custom_popup" style="display: none;">
    <div class="popup_content">
        <?php if (!empty($popup['image'])) : ?>
            <img src="<?php echo esc_url($popup['image']); ?>" alt="">
        <?php endif; ?>
        <?php if (!empty($popup['title'])) : ?>
            <h2><?php echo esc_html($popup['title']); ?></h2>
        <?php endif; ?>
        <?php if (!empty($popup['text'])) : ?>
            <p><?php echo wp_kses_post($popup['text']); ?></p>
        <?php endif; ?>
        <?php if (!empty($popup['button_text']) && !empty($popup['button_link'])) : ?>
            <a href="<?php echo esc_url($popup['button_link']); ?>"><?php echo esc_html($popup['button_text']); ?></a>
        <?php endif; ?>
        <button class="close_popup">×</button>
    </div>
</div>
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
            
                if ( $show_auth_buttons === '1') {
                    if ( ! is_user_logged_in() ) {
                        $current_lang = function_exists('pll_current_language') ? pll_current_language() : 'uk';
                        $prefix = 'translate_';
            
                        // Получаем опции переводов
                        $translate_options = get_option('template_theme_translate_options');
            
                        // Получаем текст и ссылку для кнопки "Войти" из опций
                        $login_button_text_key = 'button_login_' . $current_lang;
                        $login_button_link_key = 'button_login_link_' . $current_lang;
            
                        $login_button_text = $translate_options[$login_button_text_key] ?? '';
                        $login_button_url = $translate_options[$login_button_link_key] ?? '';
            
                        // Получаем текст и ссылку для кнопки "Регистрация" из опций
                        $register_button_text_key = 'button_registration_' . $current_lang;
                        $register_button_link_key = 'button_registration_link_' . $current_lang;
            
                        $register_button_text = $translate_options[$register_button_text_key] ?? '';
                        $register_button_url = $translate_options[$register_button_link_key] ?? '';
            
                        $login_button_output = '';
                        $register_button_output = '';
            
                        if ( ! empty( $login_button_text ) && ! empty( $login_button_url ) ) {
                            $login_button_output = '<li class="menu-item menu-item-button"><a href="' . esc_url( $login_button_url ) . '" class="button button-login">' . esc_html( $login_button_text ) . '</a></li>';
                        }
            
                        if ( ! empty( $register_button_text ) && ! empty( $register_button_url ) ) {
                            $register_button_output = '<li class="menu-item menu-item-button"><a href="' . esc_url( $register_button_url ) . '" class="button button-register">' . esc_html( $register_button_text ) . '</a></li>';
                        }
            
                        $items .= $login_button_output . $register_button_output;
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
             <?php // --- Переключатель языка ---
            if ( $show_language_switcher === '1' ) : ?>
                <?php
        if (function_exists('wpml_language_switcher')) {
            wpml_language_switcher();
        } elseif (function_exists('pll_the_languages')) {
            $languages = pll_the_languages(['raw' => 1]);
            if (!empty($languages) && count($languages) > 1) :
                $current_lang = pll_current_language();
                $current_lang_data = $languages[$current_lang];
                ?>
                <div class="language-dropdown">
                    <button class="current-lang-button">
                        <img src="<?php echo esc_url($current_lang_data['flag']); ?>" alt="<?php echo esc_attr($current_lang_data['name']); ?>" width="16" height="11" style="width: 16px; height: 11px;">
                    </button>
                    <ul class="lang-dropdown-list">
                        <?php foreach ($languages as $lang_code => $lang_data) : ?>
                            <?php if ($lang_code !== $current_lang) : ?>
                                <li class="lang-item lang-item-<?php echo esc_attr($lang_data['id']); ?> lang-item-<?php echo esc_attr($lang_code); ?>">
                                    <a lang="<?php echo esc_attr($lang_data['locale']); ?>" hreflang="<?php echo esc_attr($lang_data['locale']); ?>" href="<?php echo esc_url($lang_data['url']); ?>">
                                        <img src="<?php echo esc_url($lang_data['flag']); ?>" alt="<?php echo esc_attr($lang_data['name']); ?>" width="16" height="11" style="width: 16px; height: 11px;">
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php
            endif;
        } else {
            esc_html_e('Для отображения переключателя языка установите и активируйте WPML или Polylang.', 'template_theme');
        }
        ?><?php endif; ?>
        </nav>
    </header>
    <?php
    if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb('<div class="breadcrumbs">', '</div>');
    } else {
        // Альтернативная реализация хлебных крошек, если Yoast SEO не установлен
        echo '<div class="breadcrumbs">';
        echo '<a href="' . esc_url(home_url()) . '">Главная</a>';
        
        if (is_single() || is_page()) {
            echo ' &raquo; ';
            the_title();
        } elseif (is_category()) {
            echo ' &raquo; ';
            single_cat_title();
        } elseif (is_search()) {
            echo ' &raquo; Результаты поиска для: "' . get_search_query() . '"';
        }
        echo '</div>';
    }
    if ($banner_mobile_local || $banner_desktop_local) {
        // Определяем какое изображение использовать (мобильное/десктопное)
        $banner_image = wp_is_mobile() ? $banner_mobile_local : $banner_desktop_local;
        // Если для текущего устройства нет изображения - используем другое
        if (empty($banner_image)) $banner_image = wp_is_mobile() ? $banner_desktop : $banner_mobile;
        if (!is_404()) {
            $show_banner = true;
          }
    }
    elseif ($banner_mobile_global || $banner_desktop_global) {
        // Если локальных нет, но есть глобальные
        $banner_image = wp_is_mobile() ? $banner_mobile_global : $banner_desktop_global;
        if (empty($banner_image)) $banner_image = wp_is_mobile() ? $banner_desktop_global : $banner_mobile_global;
        if($show_banner_pages )
        $show_banner = true;
        elseif ((is_front_page() && $show_banner_main_page) || (is_category() && $show_banner_categories))
        if (!is_404()) {
          $show_banner = true;
        }
    }
    if ($show_banner) :
        ?>
        <div class="custom-banner">
            <img src="<?php echo esc_url($banner_image); ?>" alt="<?php echo esc_attr($banner_title ?: 'Баннер'); ?>" class="banner-image">
    
            <?php if ($banner_title || $banner_text || ($button_text && $button_url)) : ?>
                <div class="banner-content">
                    <?php if ($banner_title) : ?>
                        <h2 class="banner-title"><?php echo esc_html($banner_title); ?></h2>
                    <?php endif; ?>
    
                    <?php if ($banner_text) : ?>
                        <p class="banner-text"><?php echo esc_html($banner_text); ?></p>
                    <?php endif; ?>
    
                    <?php if ($button_text && $button_url) : ?>
                        <a href="<?php echo esc_url($button_url); ?>" class="banner-button">
                            <?php echo esc_html($button_text); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
    
        </div>
        <?php
    endif;
    ?>

    <div id="content" class="site-content">
        <?php // Основной контент страницы начнется здесь ?>