<?php
/**
 * Содержимое страницы настроек футера (без языковых вкладок).
 */
if (!defined('ABSPATH')) {
    exit;
}
if (!current_user_can('manage_options')) {
    return;
}

$options = get_option('template_theme_footer_options');
$footer = isset($options) ? $options : array();
?>

<div class="wrap">
    <h1><?php esc_html_e('Настройки футера', 'template_theme'); ?></h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('template_theme_footer_settings_group');
        ?>

        <h2><?php esc_html_e('Настройки иконок и ссылок', 'template_theme'); ?></h2>
        <table class="form-table">
            <?php for ($i = 1; $i <= 4; $i++) : ?>
                <tr valign="top">
                    <th scope="row"><?php printf(esc_html__('Иконка %d (URL):', 'template_theme'), $i); ?></th>
                    <td>
                        <input type="text" name="template_theme_footer_options[footer_icon_<?php echo esc_attr($i); ?>]" value="<?php echo esc_attr(isset($footer['footer_icon_' . $i]) ? $footer['footer_icon_' . $i] : ''); ?>" class="widefat">
                        <button type="button" class="upload_image_button button button-primary" data-target="template_theme_footer_options[footer_icon_<?php echo esc_attr($i); ?>]">Загрузить изображение</button>
                        <?php if (isset($footer['footer_icon_' . $i]) && $footer['footer_icon_' . $i]): ?>
                            <img src="<?php echo esc_url($footer['footer_icon_' . $i]); ?>" alt="<?php printf('Иконка %d', $i); ?>" style="max-width: 100px;">
                        <?php endif; ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php printf(esc_html__('Ссылка %d:', 'template_theme'), $i); ?></th>
                    <td>
                        <input type="text" name="template_theme_footer_options[footer_link_<?php echo esc_attr($i); ?>]" value="<?php echo esc_attr(isset($footer['footer_link_' . $i]) ? $footer['footer_link_' . $i] : ''); ?>" class="widefat">
                    </td>
                </tr>
            <?php endfor; ?>
        </table>

        <h2><?php esc_html_e('Текст копирайта', 'template_theme'); ?></h2>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php esc_html_e('Текст копирайта:', 'template_theme'); ?></th>
                <td>
                    <textarea name="template_theme_footer_options[footer_copyright_text]" class="widefat"><?php echo esc_textarea(isset($footer['footer_copyright_text']) ? $footer['footer_copyright_text'] : ''); ?></textarea>
                </td>
            </tr>
        </table>

        <?php submit_button(__('Сохранить настройки', 'template_theme')); ?>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    // Обработчик кнопки загрузки изображения
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