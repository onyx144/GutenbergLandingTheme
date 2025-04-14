<?php
/**
 * Содержимое вкладки "Style" с использованием Settings API.
 */
if (!defined('ABSPATH')) {
    exit;
}
if (!current_user_can('manage_options')) {
    return;
}

$options = get_option('template_theme_style_options');
$style = isset($options) ? $options : array();
?>

<form method="post" action="options.php">
    <?php
    settings_fields('template_theme_style_settings_group');
    do_settings_sections('style_settings');
    ?>

    <h2><?php esc_html_e('Настройки стилей', 'template_theme'); ?></h2>

    <label for="template_theme_style_options[site_background_color]">
        <?php esc_html_e('Цвет фона сайта:', 'template_theme'); ?>
    </label>
    <input type="color" name="template_theme_style_options[site_background_color]" value="<?php echo esc_attr(isset($style['site_background_color']) ? $style['site_background_color'] : '#ffffff'); ?>">

    <label for="template_theme_style_options[site_font_family]">
        <?php esc_html_e('Шрифт сайта:', 'template_theme'); ?>
    </label>
    <select name="template_theme_style_options[site_font_family]">
        <option value="Arial" <?php selected(isset($style['site_font_family']) ? $style['site_font_family'] : '', 'Arial'); ?>>Arial</option>
        <option value="Helvetica" <?php selected(isset($style['site_font_family']) ? $style['site_font_family'] : '', 'Helvetica'); ?>>Helvetica</option>
        <option value="Times New Roman" <?php selected(isset($style['site_font_family']) ? $style['site_font_family'] : '', 'Times New Roman'); ?>>Times New Roman</option>
        <option value="Georgia" <?php selected(isset($style['site_font_family']) ? $style['site_font_family'] : '', 'Georgia'); ?>>Georgia</option>
        <option value="Verdana" <?php selected(isset($style['site_font_family']) ? $style['site_font_family'] : '', 'Verdana'); ?>>Verdana</option>
    </select>

    <label for="template_theme_style_options[site_font_color]">
        <?php esc_html_e('Цвет шрифта сайта:', 'template_theme'); ?>
    </label>
    <input type="color" name="template_theme_style_options[site_font_color]" value="<?php echo esc_attr(isset($style['site_font_color']) ? $style['site_font_color'] : '#000000'); ?>">

    <label for="template_theme_style_options[site_font_size]">
        <?php esc_html_e('Размер шрифта сайта (px):', 'template_theme'); ?>
    </label>
    <input type="number" name="template_theme_style_options[site_font_size]" value="<?php echo esc_attr(isset($style['site_font_size']) ? $style['site_font_size'] : '16'); ?>">

    <label for="template_theme_style_options[table_style]">
        <?php esc_html_e('Стиль таблиц:', 'template_theme'); ?>
    </label>
    <textarea name="template_theme_style_options[table_style]" class="widefat"><?php echo esc_textarea(isset($style['table_style']) ? $style['table_style'] : 'border: 1px solid #ccc;'); ?></textarea>

    <label for="template_theme_style_options[heading_default_color]">
        <?php esc_html_e('Цвет заголовков (по умолчанию):', 'template_theme'); ?>
    </label>
    <input type="color" name="template_theme_style_options[heading_default_color]" value="<?php echo esc_attr(isset($style['heading_default_color']) ? $style['heading_default_color'] : '#333333'); ?>">

    <label for="template_theme_style_options[h1_color]">
        <?php esc_html_e('Цвет H1:', 'template_theme'); ?>
    </label>
    <input type="color" name="template_theme_style_options[h1_color]" value="<?php echo esc_attr(isset($style['h1_color']) ? $style['h1_color'] : ''); ?>">

    <label for="template_theme_style_options[h2_color]">
        <?php esc_html_e('Цвет H2:', 'template_theme'); ?>
    </label>
    <input type="color" name="template_theme_style_options[h2_color]" value="<?php echo esc_attr(isset($style['h2_color']) ? $style['h2_color'] : ''); ?>">

    <label for="template_theme_style_options[p_color]">
        <?php esc_html_e('Цвет P:', 'template_theme'); ?>
    </label>
    <input type="color" name="template_theme_style_options[p_color]" value="<?php echo esc_attr(isset($style['p_color']) ? $style['p_color'] : ''); ?>">

    <label for="template_theme_style_options[a_color]">
        <?php esc_html_e('Цвет ссылок:', 'template_theme'); ?>
    </label>
    <input type="color" name="template_theme_style_options[a_color]" value="<?php echo esc_attr(isset($style['a_color']) ? $style['a_color'] : '#007bff'); ?>">

    <?php submit_button(__('Сохранить настройки', 'template_theme')); ?>
</form>