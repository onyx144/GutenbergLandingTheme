<?php
/**
 * Содержимое вкладки "Опции страниц" с использованием Settings API.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! current_user_can( 'manage_options' ) ) { return; }

$options = get_option('custom_blocks_options');
$popup = isset($options['popup']) ? $options['popup'] : array();
?>

<form method="post" action="options.php">
   
    <h2>Настройки Pop-up</h2>
    <label>Изображение Pop-up:</label>
    <input type="text" name="custom_blocks_options[popup][image]" value="<?php echo esc_attr($popup['image']); ?>" class="widefat">
    <button type="button" class="upload_image_button button button-primary" data-target="custom_blocks_options[popup][image]">Загрузить изображение</button>
    <label>Заголовок Pop-up:</label>
    <input type="text" name="custom_blocks_options[popup][title]" value="<?php echo esc_attr($popup['title']); ?>" class="widefat">
    <label>Текст Pop-up:</label>
    <textarea name="custom_blocks_options[popup][text]" class="widefat"><?php echo esc_textarea($popup['text']); ?></textarea>
    <label>Текст кнопки Pop-up:</label>
    <input type="text" name="custom_blocks_options[popup][button_text]" value="<?php echo esc_attr($popup['button_text']); ?>" class="widefat">
    <label>Ссылка кнопки Pop-up:</label>
    <input type="text" name="custom_blocks_options[popup][button_link]" value="<?php echo esc_attr($popup['button_link']); ?>" class="widefat">

    <label>Условие показа Pop-up:</label>
    <select name="custom_blocks_options[popup][condition]">
        <option value="timer" <?php selected($popup['condition'], 'timer'); ?>>Таймер</option>
        <option value="scroll" <?php selected($popup['condition'], 'scroll'); ?>>Прокрутка</option>
        <option value="pages" <?php selected($popup['condition'], 'pages'); ?>>Переходы по страницам</option>
        <option value="wait" <?php selected($popup['condition'], 'wait'); ?>>Время ожидания</option>
    </select>

    <label>Значение условия (сек, %, страницы, сек):</label>
    <input type="number" name="custom_blocks_options[popup][condition_value]" value="<?php echo esc_attr($popup['condition_value']); ?>" class="widefat">

    <?php submit_button('Сохранить настройки Pop-up'); ?>
</form>

<script>
jQuery(document).ready(function($) {
    $(document).on('click', '.upload_image_button', function(e) {
        e.preventDefault();
        var target = $(this).data('target');
        var image = wp.media({
            title: 'Загрузить изображение',
            multiple: false
        }).open()
        .on('select', function() {
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $('input[name="' + target + '"]').val(image_url);
        });
    });
});
</script>
<?php
?>