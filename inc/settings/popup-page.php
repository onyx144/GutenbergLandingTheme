<?php
/**
 * Содержимое вкладки "Pop-up" с использованием Settings API.
 */
if (!defined('ABSPATH')) {
    exit;
}
if (!current_user_can('manage_options')) {
    return;
}

$options = get_option('template_theme_popup_options');
$popup = isset($options) ? $options : array();
?>

<form method="post" action="options.php">
    <?php
    settings_fields('template_theme_popup_settings_group');
    //do_settings_sections('popup_settings');
    ?>

    <h2><?php esc_html_e('Настройки Pop-up', 'template_theme'); ?></h2>

    <label for="template_theme_popup_options[popup_image]">
        <?php esc_html_e('Изображение:', 'template_theme'); ?>
    </label>
    <input type="text" name="template_theme_popup_options[popup_image]" value="<?php echo esc_attr(isset($popup['popup_image']) ? $popup['popup_image'] : ''); ?>" class="widefat">
    <button type="button" class="upload_image_button button button-primary" data-target="template_theme_popup_options[popup_image]">Загрузить изображение</button>
    <?php if (isset($popup['popup_image']) && $popup['popup_image']): ?>
        <img src="<?php echo esc_url($popup['popup_image']); ?>" alt="Pop-up Image" style="max-width: 100px;">
    <?php endif; ?>
    <label for="template_theme_popup_options[popup_title]">
        <?php esc_html_e('Заголовок:', 'template_theme'); ?>
    </label>
    <input type="text" name="template_theme_popup_options[popup_title]" value="<?php echo esc_attr(isset($popup['popup_title']) ? $popup['popup_title'] : ''); ?>" class="widefat">

    <label for="template_theme_popup_options[popup_text]">
        <?php esc_html_e('Текст:', 'template_theme'); ?>
    </label>
    <textarea name="template_theme_popup_options[popup_text]" class="widefat"><?php echo esc_textarea(isset($popup['popup_text']) ? $popup['popup_text'] : ''); ?></textarea>

    <label for="template_theme_popup_options[popup_button_text]">
        <?php esc_html_e('Текст кнопки:', 'template_theme'); ?>
    </label>
    <input type="text" name="template_theme_popup_options[popup_button_text]" value="<?php echo esc_attr(isset($popup['popup_button_text']) ? $popup['popup_button_text'] : ''); ?>" class="widefat">

    <label for="template_theme_popup_options[popup_button_link]">
        <?php esc_html_e('Ссылка кнопки:', 'template_theme'); ?>
    </label>
    <input type="text" name="template_theme_popup_options[popup_button_link]" value="<?php echo esc_attr(isset($popup['popup_button_link']) ? $popup['popup_button_link'] : ''); ?>" class="widefat">

    <label for="template_theme_popup_options[popup_condition]">
        <?php esc_html_e('Условие показа:', 'template_theme'); ?>
    </label>
    <select name="template_theme_popup_options[popup_condition]">
        <option value="timer" <?php selected(isset($popup['popup_condition']) ? $popup['popup_condition'] : '', 'timer'); ?>><?php esc_html_e('Таймер (сек)', 'template_theme'); ?></option>
        <option value="scroll" <?php selected(isset($popup['popup_condition']) ? $popup['popup_condition'] : '', 'scroll'); ?>><?php esc_html_e('Прокрутка (%)', 'template_theme'); ?></option>
        <option value="page_load" <?php selected(isset($popup['popup_condition']) ? $popup['popup_condition'] : '', 'page_load'); ?>><?php esc_html_e('При загрузке страницы', 'template_theme'); ?></option>
        <option value="wait_time" <?php selected(isset($popup['popup_condition']) ? $popup['popup_condition'] : '', 'wait_time'); ?>><?php esc_html_e('Время ожидания (сек)', 'template_theme'); ?></option>
    </select>

    <label for="template_theme_popup_options[popup_condition_value]">
        <?php esc_html_e('Значение условия:', 'template_theme'); ?>
    </label>
    <input type="number" name="template_theme_popup_options[popup_condition_value]" value="<?php echo esc_attr(isset($popup['popup_condition_value']) ? $popup['popup_condition_value'] : '5'); ?>">

    <?php submit_button(__('Сохранить настройки', 'template_theme')); ?>
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