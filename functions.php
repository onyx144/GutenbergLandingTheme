<?php
/**
 * Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package template_theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Замените на версию вашей темы
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */

function template_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on template_theme, use a find and replace
		* to change 'template_theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'template_theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

    // Можно задать стандартный размер миниатюр
    // set_post_thumbnail_size( 1568, 9999 );

	// Регистрация области меню
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'template_theme' ),
            // 'footer' => esc_html__( 'Footer Menu', 'template_theme'), // Можно добавить и другие области
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'template_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'template_theme_setup' );

require get_template_directory() . '/inc/admin/short-block-setting.php';
require get_template_directory() . '/inc/admin/header-settings-api.php';
require get_template_directory() . '/inc/admin/page-option-api.php';
require get_template_directory() . '/inc/admin/pop-up.php';
require get_template_directory() . '/inc/admin/style-register.php';
require get_template_directory() . '/inc/admin/translate-meta-fields.php';
require get_template_directory() . '/inc/admin/footer-meta-fields.php';
require get_template_directory() . '/inc/admin/link-edit.php';

require_once( get_template_directory() . '/inc/admin/functions-admin.php' );
require_once( get_template_directory() . '/inc/admin/function-tos.php' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function template_theme_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'template_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'template_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function template_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'template_theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'template_theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'template_theme_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function template_theme_scripts() {
	// Подключаем основной файл стилей темы (style.css)
    wp_enqueue_style( 'template_theme-style', get_stylesheet_uri(), array(), _S_VERSION );

    // Если вы создадите другие файлы CSS (напр. в папке /css/)
	// wp_enqueue_style( 'template_theme-custom-style', get_template_directory_uri() . '/css/custom.css', array('template_theme-style'), _S_VERSION );

	// Подключаем стандартный JS для древовидных комментариев (если они используются)
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    // Если вы создадите свои JS файлы (напр. в папке /js/)
    // wp_enqueue_script( 'template_theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true ); // true = грузить в футере
}
add_action( 'wp_enqueue_scripts', 'template_theme_scripts' );

/**
 * Implement the Custom Header feature.
 */
// require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
// require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
// require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
// require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
// if ( defined( 'JETPACK__VERSION' ) ) {
// 	require get_template_directory() . '/inc/jetpack.php';
// }

// Здесь можно добавлять ваши собственные функции, хуки и фильтры

function template_theme_enqueue_scripts() {
    wp_enqueue_script( 'template-theme-script', get_template_directory_uri() . '/asset/js/script.js', array( 'jquery' ), '1.0.011', true );
}
add_action( 'wp_enqueue_scripts', 'template_theme_enqueue_scripts' );

function template_theme_add_admin_menu() {
    add_menu_page(
        __( 'Настройки темы', 'template_theme' ), // Заголовок страницы (title)
        __( 'Настройки темы', 'template_theme' ), // Название пункта меню
        'manage_options',                         // Необходимые права пользователя (обычно 'manage_options' для админов)
        'template_theme_settings',                // Уникальный идентификатор (slug) страницы меню
        'template_theme_render_settings_page',    // Функция, которая будет отображать содержимое страницы
        'dashicons-admin-settings',               // Иконка меню (можно выбрать из Dashicons)
        60                                        // Позиция в меню (необязательно, ~60 - ниже "Внешний вид")
    );
}
add_action( 'admin_menu', 'template_theme_add_admin_menu' );

/**
 * Отображает содержимое страницы настроек темы.
 * Эта функция вызывается как колбэк в add_menu_page().
 */
function template_theme_render_settings_page() {
    // Проверка прав пользователя
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Определяем активную вкладку. По умолчанию - 'header'.
    $active_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'header';
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

        <h2 class="nav-tab-wrapper">
            <a href="?page=template_theme_settings&tab=header" class="nav-tab <?php echo $active_tab == 'header' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Header', 'template_theme' ); ?>
            </a>
			<a href="?page=template_theme_settings&tab=page_option" class="nav-tab <?php echo $active_tab == 'page_option' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Page Option', 'template_theme' ); ?>
            </a>
            <a href="?page=template_theme_settings&tab=footer" class="nav-tab <?php echo $active_tab == 'footer' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Footer', 'template_theme' ); ?>
            </a>
            <a href="?page=template_theme_settings&tab=translate" class="nav-tab <?php echo $active_tab == 'translate' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Translate', 'template_theme' ); ?>
            </a>
            <a href="?page=template_theme_settings&tab=style" class="nav-tab <?php echo $active_tab == 'style' ? 'nav-tab-active' : ''; ?>">
              <?php esc_html_e( 'Style', 'template_theme' ); ?>
            </a>
            <a href="?page=template_theme_settings&tab=popup" class="nav-tab <?php echo $active_tab == 'popup' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Pop Up', 'template_theme' ); ?>
            </a>
            <a href="?page=template_theme_settings&tab=shortcode_block" class="nav-tab <?php echo $active_tab == 'shortcode_block' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Shortcode Block', 'template_theme' ); ?>
            </a>
            <a href="?page=template_theme_settings&tab=plagin" class="nav-tab <?php echo $active_tab == 'plagin' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Plagins', 'template_theme' ); ?>
            </a>

            <?php // Сюда можно добавить ссылки на другие вкладки, если понадобится ?>
        </h2>

        <form action="options.php" method="post">
            <?php
            /*
             * Важно: Сохранение настроек для разных вкладок мы настроим позже,
             * используя WordPress Settings API. Пока что форма и кнопки скрыты/неактивны.
             * Возможно, понадобится регистрировать разные группы настроек для каждой вкладки.
             */
            // settings_fields( 'template_theme_settings_group_' . $active_tab ); // Пример динамической группы
            // do_settings_sections( 'template_theme_settings_' . $active_tab );    // Пример динамической секции


            // Подключаем файл с контентом для активной вкладки
            $settings_dir = get_template_directory() . '/inc/settings/'; // Путь к папке с файлами настроек
            $admin_dir = get_template_directory() . '/inc/admin/'; // Путь к папке с файлами настроек

            if ( $active_tab == 'header' ) {
                $settings_file = $settings_dir . 'header-settings.php';
            } 
			elseif ( $active_tab == 'page_option' ) {
                $settings_file = $settings_dir . 'page-option.php';
			}elseif ( $active_tab == 'footer' ) {
                $settings_file = $settings_dir . 'footer-settings-page.php';
            } 
            elseif ( $active_tab == 'translate' ) {
                $settings_file = $settings_dir . 'translate-settings-page.php';
            } 
            elseif ( $active_tab == 'popup' ) {
                $settings_file = $settings_dir . 'popup-page.php';
            } 
            elseif ( $active_tab == 'style' ) {
                $settings_file = $settings_dir . 'style-settings.php';
            } 
            elseif ( $active_tab == 'plagin' ) {
                $settings_file = $settings_dir . 'plagins-options.php';
            }
            elseif ( $active_tab == 'shortcode_block' ) {
                $settings_file = $settings_dir . 'shortcode-block.php';
            }
            else {
                // Если вкладка неизвестна, можно показать вкладку по умолчанию или ошибку
                $settings_file = $settings_dir . 'header-settings.php';
            }

            if ( file_exists( $settings_file ) ) {
                include( $settings_file );
            } else {
                echo '<p>' . esc_html__( 'Файл настроек не найден.', 'template_theme' ) . '</p>';
            }

            // Вывод кнопки сохранения (пока закомментирован)
            // submit_button( __( 'Сохранить настройки', 'template_theme' ) );
            ?>
             <p style="margin-top: 20px;"><em><?php esc_html_e( 'Примечание: Поля для ввода и сохранение настроек будут добавлены позже.', 'template_theme' ); ?></em></p>
        </form>

    </div><?php
}


/**
 * Добавляем метаполя для страниц и категорий.
 */
function template_theme_add_banner_meta_boxes() {
    add_meta_box(
        'template_theme_banner_settings',
        'Настройки баннера',
        'template_theme_render_banner_meta_box',
        ['page', 'category'],
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'template_theme_add_banner_meta_boxes');

/**
 * Отрисовка метаполя баннера.
 */
function template_theme_render_banner_meta_box($post) {
    // Получаем значения метаполей
    $banner_mobile = get_post_meta($post->ID, 'banner_mobile', true);
    $banner_desktop = get_post_meta($post->ID, 'banner_desktop', true);
    $banner_title = get_post_meta($post->ID, 'banner_title', true);
    $banner_text = get_post_meta($post->ID, 'banner_text', true);
    $button_text = get_post_meta($post->ID, 'button_text', true);
    $button_url = get_post_meta($post->ID, 'button_url', true);
    $icon1 = get_post_meta($post->ID, 'icon1', true);
    $link1 = get_post_meta($post->ID, 'link1', true);
    $icon2 = get_post_meta($post->ID, 'icon2', true);
    $link2 = get_post_meta($post->ID, 'link2', true);
    $icon3 = get_post_meta($post->ID, 'icon3', true);
    $link3 = get_post_meta($post->ID, 'link3', true);

    // Выводим поля для ввода
    ?>
    <p>
        <label for="banner_mobile">Мобильный баннер:</label><br>
        <input type="text" id="banner_mobile" name="banner_mobile" value="<?php echo esc_attr($banner_mobile); ?>" class="widefat">
        <button class="upload_image_button button button-primary" data-target="banner_mobile">Загрузить изображение</button>
        <?php if ($banner_mobile) : ?>
            <img src="<?php echo esc_url($banner_mobile); ?>" style="max-width: 100px; max-height: 100px;">
        <?php endif; ?>
    </p>

    <p>
        <label for="banner_desktop">Десктоп баннер:</label><br>
        <input type="text" id="banner_desktop" name="banner_desktop" value="<?php echo esc_attr($banner_desktop); ?>" class="widefat">
        <button class="upload_image_button button button-primary" data-target="banner_desktop">Загрузить изображение</button>
        <?php if ($banner_desktop) : ?>
            <img src="<?php echo esc_url($banner_desktop); ?>" style="max-width: 100px; max-height: 100px;">
        <?php endif; ?>
    </p>

    <p>
        <label for="banner_title">Заголовок:</label><br>
        <input type="text" id="banner_title" name="banner_title" value="<?php echo esc_attr($banner_title); ?>" class="widefat">
    </p>

    

    <p>
        <label for="icon1">Иконка 1:</label><br>
        <input type="text" id="icon1" name="icon1" value="<?php echo esc_attr($icon1); ?>" class="widefat">
        <button class="upload_image_button button button-primary" data-target="icon1">Загрузить изображение</button>
        <?php if ($icon1) : ?>
            <img src="<?php echo esc_url($icon1); ?>" style="max-width: 50px; max-height: 50px;">
        <?php endif; ?>
    </p>

    <p>
        <label for="text1">Ссылка 1:</label><br>
        <input type="text" id="text1" name="text1" value="<?php echo esc_attr($text1); ?>" class="widefat">
    </p>

    <p>
        <label for="icon2">Иконка 2:</label><br>
        <input type="text" id="icon2" name="icon2" value="<?php echo esc_attr($icon2); ?>" class="widefat">
        <button class="upload_image_button button button-primary" data-target="icon2">Загрузить изображение</button>
        <?php if ($icon2) : ?>
            <img src="<?php echo esc_url($icon2); ?>" style="max-width: 50px; max-height: 50px;">
        <?php endif; ?>
    </p>

    <p>
        <label for="text2">Ссылка 2:</label><br>
        <input type="text" id="text2" name="text2" value="<?php echo esc_attr($text2); ?>" class="widefat">
    </p>

    <p>
        <label for="icon3">Иконка 3:</label><br>
        <input type="text" id="icon3" name="icon3" value="<?php echo esc_attr($icon3); ?>" class="widefat">
        <button class="upload_image_button button button-primary" data-target="icon3">Загрузить изображение</button>
        <?php if ($icon3) : ?>
            <img src="<?php echo esc_url($icon3); ?>" style="max-width: 50px; max-height: 50px;">
        <?php endif; ?>
    </p>

    <p>
        <label for="text3">Ссылка 3:</label><br>
        <input type="text" id="text3" name="text3" value="<?php echo esc_attr($text3); ?>" class="widefat">
    </p>

    <script>
        jQuery(document).ready(function($) {
            $('.upload_image_button').click(function(e) {
                e.preventDefault();
                var target = $(this).data('target');
                var image = wp.media({
                    title: 'Загрузить изображение',
                    multiple: false
                }).open()
                .on('select', function() {
                    var uploaded_image = image.state().get('selection').first();
                    var image_url = uploaded_image.toJSON().url;
                    $('#' + target).val(image_url);
                });
            });
        });
    </script>
    <?php
}

/**
 * Сохранение метаполей баннера.
 */
function template_theme_save_banner_meta_box($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['banner_mobile'])) {
        update_post_meta($post_id, 'banner_mobile', esc_url_raw($_POST['banner_mobile']));
    }
    if (isset($_POST['banner_desktop'])) {
        update_post_meta($post_id, 'banner_desktop', esc_url_raw($_POST['banner_desktop']));
    }
    if (isset($_POST['banner_title'])) {
        update_post_meta($post_id, 'banner_title', sanitize_text_field($_POST['banner_title']));
    }
    if (isset($_POST['banner_text'])) {
        update_post_meta($post_id, 'banner_text', sanitize_textarea_field($_POST['banner_text']));
    }
    if (isset($_POST['button_text'])) {
        update_post_meta($post_id, 'button_text', sanitize_text_field($_POST['button_text']));
    }
    if (isset($_POST['button_url'])) {
        update_post_meta($post_id, 'button_url', esc_url_raw($_POST['button_url']));
    }
    if (isset($_POST['icon1'])) {
        update_post_meta($post_id, 'icon1', esc_url_raw($_POST['icon1']));
    }
    if (isset($_POST['text1'])) {
        update_post_meta($post_id, 'text1', sanitize_text_field($_POST['text1']));
    }
    if (isset($_POST['icon2'])) {
        update_post_meta($post_id, 'icon2', esc_url_raw($_POST['icon2']));
    }
    if (isset($_POST['text2'])) {
        update_post_meta($post_id, 'text2', sanitize_text_field($_POST['text2']));
    }
    if (isset($_POST['icon3'])) {
        update_post_meta($post_id, 'icon3', esc_url_raw($_POST['icon3']));
    }
    if (isset($_POST['text3'])) {
        update_post_meta($post_id, 'text3', sanitize_text_field($_POST['text3']));
    }
}
add_action('save_post', 'template_theme_save_banner_meta_box');

/**
 * Вывод баннера после хедера
 */
