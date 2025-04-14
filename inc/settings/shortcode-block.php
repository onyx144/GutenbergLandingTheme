<?php
/**
 * Содержимое вкладки "Опции страниц" с использованием Settings API.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! current_user_can( 'manage_options' ) ) { return; }

echo '<div class="wrap">';
echo '<h1>Настройки блоков</h1>';

// Форма для создания блоков
echo '<form method="post" action="options.php">';
settings_fields('custom_blocks_options_group');
do_settings_sections('custom-blocks');
submit_button('Сохранить блоки');
echo '</form>';

echo '</div>';
?>
