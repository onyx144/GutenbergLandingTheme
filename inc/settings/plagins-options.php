<?php
/**
 * Plagins Options - Настройки плагинов.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Защита от прямого доступа
if ( ! current_user_can( 'manage_options' ) ) { return; } // Проверка прав

// Подключаем функции
require_once( get_template_directory() . '/inc/admin/functions-admin.php' );

// Проверяем, установлен ли Yoast SEO
$yoast_installed = template_theme_is_yoast_seo_installed();

if ( $yoast_installed ) {
    echo '<p>Yoast SEO установлен.</p>';
} else {
    ?>
    <form id="install-yoast-form">
        <button type="button" id="install-yoast-button">Установить Yoast SEO</button>
        <div id="install-yoast-result"></div>
    </form>

    <script>
        jQuery(document).ready(function($) {
            $('#install-yoast-button').click(function() {
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'install_yoast_seo'
                    },
                    success: function(response) {
                        $('#install-yoast-result').html(response);
                    }
                });
            });
        });
    </script>
    <?php
}

// Добавляем обработчик AJAX-запроса
add_action('wp_ajax_install_yoast_seo', 'template_theme_ajax_install_yoast_seo');

function template_theme_ajax_install_yoast_seo() {
    $install_result = template_theme_install_yoast_seo();
    if ( $install_result ) {
        echo '<p>Yoast SEO успешно установлен.</p>';
    } else {
        echo '<p>Ошибка установки Yoast SEO.</p>';
    }
    wp_die();
}
?>