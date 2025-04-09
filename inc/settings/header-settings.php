<?php
/**
 * Содержимое вкладки "Настройки Хедера" с использованием Settings API
 */
if ( ! defined( 'ABSPATH' ) ) { exit; } // Защита от прямого доступа
if ( ! current_user_can( 'manage_options' ) ) { return; } // Проверка прав
?>

<form method="post" action="options.php">
    <?php
    settings_fields( 'template_theme_header_settings_group' ); // Группа настроек хедера
    do_settings_sections( 'template_theme_settings' ); // Slug страницы настроек
    submit_button( __( 'Сохранить настройки хедера', 'template_theme' ) );
    ?>
</form>