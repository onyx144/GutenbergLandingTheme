<?php
/**
 * Содержимое вкладки "Pop-up" с использованием Settings API и переключателем языков (без перезагрузки).
 */
if (!defined('ABSPATH')) {
    exit;
}
if (!current_user_can('manage_options')) {
    return;
}

$options = get_option('template_theme_popup_options');
$popup = isset($options) ? $options : array();
$languages = ['uk' => 'Українська', 'en' => 'English', 'es' => 'Español'];
$current_lang_tab = isset($_GET['lang']) ? sanitize_key($_GET['lang']) : 'uk'; // Сохраняем для активности вкладки при первой загрузке
?>

<div class="popup-settings-tabs">
    <h2 class="nav-tab-wrapper">
        <?php foreach ($languages as $lang => $lang_name) : ?>
            <a href="#<?php echo esc_attr($lang); ?>" class="nav-tab <?php if ($lang === $current_lang_tab) echo 'nav-tab-active'; ?>" data-lang="<?php echo esc_attr($lang); ?>">
                <?php echo esc_html($lang_name); ?>
            </a>
        <?php endforeach; ?>
    </h2>

    <form method="post" action="options.php">
        <?php
        settings_fields('template_theme_popup_settings_group');
        ?>

        <?php foreach ($languages as $lang => $lang_name) : ?>
            <div id="lang-<?php echo esc_attr($lang); ?>" class="lang-tab-content" <?php if ($lang !== $current_lang_tab) echo 'style="display: none;"'; ?>>
                <h3><?php printf(esc_html__('Настройки Pop-up (%s)', 'template_theme'), $lang_name); ?></h3>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e('Изображение:', 'template_theme'); ?></th>
                        <td>
                            <input type="text" name="template_theme_popup_options[popup_image_<?php echo esc_attr($lang); ?>]" value="<?php echo esc_attr(isset($popup['popup_image_' . $lang]) ? $popup['popup_image_' . $lang] : ''); ?>" class="widefat">
                            <button type="button" class="upload_image_button button button-primary" data-target="template_theme_popup_options[popup_image_<?php echo esc_attr($lang); ?>]">Загрузить изображение</button>
                            <?php if (isset($popup['popup_image_' . $lang]) && $popup['popup_image_' . $lang]): ?>
                                <img src="<?php echo esc_url($popup['popup_image_' . $lang]); ?>" alt="Pop-up Image (<?php echo esc_attr($lang); ?>)" style="max-width: 100px;">
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e('Заголовок:', 'template_theme'); ?></th>
                        <td>
                            <input type="text" name="template_theme_popup_options[popup_title_<?php echo esc_attr($lang); ?>]" value="<?php echo esc_attr(isset($popup['popup_title_' . $lang]) ? $popup['popup_title_' . $lang] : ''); ?>" class="widefat">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e('Текст:', 'template_theme'); ?></th>
                        <td>
                            <textarea name="template_theme_popup_options[popup_text_<?php echo esc_attr($lang); ?>]" class="widefat"><?php echo esc_textarea(isset($popup['popup_text_' . $lang]) ? $popup['popup_text_' . $lang] : ''); ?></textarea>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e('Текст кнопки:', 'template_theme'); ?></th>
                        <td>
                            <input type="text" name="template_theme_popup_options[popup_button_text_<?php echo esc_attr($lang); ?>]" value="<?php echo esc_attr(isset($popup['popup_button_text_' . $lang]) ? $popup['popup_button_text_' . $lang] : ''); ?>" class="widefat">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e('Ссылка кнопки:', 'template_theme'); ?></th>
                        <td>
                            <input type="text" name="template_theme_popup_options[popup_button_link_<?php echo esc_attr($lang); ?>]" value="<?php echo esc_attr(isset($popup['popup_button_link_' . $lang]) ? $popup['popup_button_link_' . $lang] : ''); ?>" class="widefat">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e('Условие показа:', 'template_theme'); ?></th>
                        <td>
                            <select name="template_theme_popup_options[popup_condition_<?php echo esc_attr($lang); ?>]">
                                <option value="timer" <?php selected(isset($popup['popup_condition_' . $lang]) ? $popup['popup_condition_' . $lang] : '', 'timer'); ?>><?php esc_html_e('Таймер (сек)', 'template_theme'); ?></option>
                                <option value="scroll" <?php selected(isset($popup['popup_condition_' . $lang]) ? $popup['popup_condition_' . $lang] : '', 'scroll'); ?>><?php esc_html_e('Прокрутка (%)', 'template_theme'); ?></option>
                                <option value="page_load" <?php selected(isset($popup['popup_condition_' . $lang]) ? $popup['popup_condition_' . $lang] : '', 'page_load'); ?>><?php esc_html_e('При загрузке страницы', 'template_theme'); ?></option>
                                <option value="wait_time" <?php selected(isset($popup['popup_condition_' . $lang]) ? $popup['popup_condition_' . $lang] : '', 'wait_time'); ?>><?php esc_html_e('Время ожидания (сек)', 'template_theme'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e('Значение условия:', 'template_theme'); ?></th>
                        <td>
                            <input type="number" name="template_theme_popup_options[popup_condition_value_<?php echo esc_attr($lang); ?>]" value="<?php echo esc_attr(isset($popup['popup_condition_value_' . $lang]) ? $popup['popup_condition_value_' . $lang] : '5'); ?>" class="small-text">
                        </td>
                    </tr>
                </table>
            </div>
        <?php endforeach; ?>

        <?php submit_button(__('Сохранить настройки', 'template_theme')); ?>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    // Обработчик клика по вкладкам языка
    $('.nav-tab-wrapper a').click(function(e) {
        e.preventDefault();
        var lang = $(this).data('lang');

        // Деактивируем все вкладки и скрываем все содержимое
        $('.nav-tab-wrapper a').removeClass('nav-tab-active');
        $('.lang-tab-content').hide();

        // Активируем текущую вкладку и показываем соответствующее содержимое
        $(this).addClass('nav-tab-active');
        $('#lang-' + lang).show();
    });

    // Обработчик кнопки загрузки изображения (остается без изменений)
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
<style>
    .popup-settings-tabs .nav-tab-wrapper {
        margin-bottom: 20px;
    }
    .popup-settings-tabs .lang-tab-content {
        border: 1px solid #ccc;
        padding: 15px;
        background-color: #fff;
    }
</style>