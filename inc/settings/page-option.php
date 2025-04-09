<?php
/**
 * Содержимое вкладки "Опции страниц" с использованием Settings API.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! current_user_can( 'manage_options' ) ) { return; }
?>

<div class="wrap">
    <h1><?php esc_html_e( 'Опции страниц', 'template_theme' ); ?></h1>
    <form method="post" action="options.php">
        <?php
        settings_fields( 'template_theme_banner_options_group' );
        do_settings_sections( 'template_theme_page_options' );
        submit_button( __( 'Сохранить настройки', 'template_theme' ) );
        ?>
    </form>
</div>