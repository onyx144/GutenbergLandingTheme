<?php
/**
 * Создает страницу настроек "Translate" и отображает поля для ввода метаполей.
 */
if (!defined('ABSPATH')) {
    exit;
}
    $options = get_option('template_theme_translate_options');
    $languages = ['uk' => 'Українська', 'en' => 'English', 'es' => 'Español'];
    $current_lang_tab = isset($_GET['lang']) ? sanitize_key($_GET['lang']) : 'uk';
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Translate', 'template_theme'); ?></h1>
        <div class="translate-settings-tabs">
            <h2 class="nav-tab-wrapper">
                <?php foreach ($languages as $lang => $lang_name) : ?>
                    <a href="#<?php echo esc_attr($lang); ?>" class="nav-tab language-tab-link <?php if ($lang === $current_lang_tab) echo 'nav-tab-active'; ?>" data-lang="<?php echo esc_attr($lang); ?>">
                        <?php echo esc_html($lang_name); ?>
                    </a>
                <?php endforeach; ?>
            </h2>

            <form method="post" action="options.php">
                <?php
                settings_fields('template_theme_translate_settings_group');
                ?>

                <?php foreach ($languages as $lang => $lang_name) : ?>
                    <div id="lang-<?php echo esc_attr($lang); ?>" class="lang-tab-content" <?php if ($lang !== $current_lang_tab) echo 'style="display: none;"'; ?>>
                        <h3><?php printf(esc_html__('Переводы (%s)', 'template_theme'), $lang_name); ?></h3>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Текст кнопки "Войти":', 'template_theme'); ?></th>
                                <td>
                                    <input type="text" name="template_theme_translate_options[button_login_<?php echo esc_attr($lang); ?>]" value="<?php echo esc_attr(isset($options['button_login_' . $lang]) ? $options['button_login_' . $lang] : ''); ?>" class="widefat">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Ссылка кнопки "Войти":', 'template_theme'); ?></th>
                                <td>
                                    <input type="text" name="template_theme_translate_options[button_login_link_<?php echo esc_attr($lang); ?>]" value="<?php echo esc_attr(isset($options['button_login_link_' . $lang]) ? $options['button_login_link_' . $lang] : ''); ?>" class="widefat">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Текст кнопки "Регистрация":', 'template_theme'); ?></th>
                                <td>
                                    <input type="text" name="template_theme_translate_options[button_registration_<?php echo esc_attr($lang); ?>]" value="<?php echo esc_attr(isset($options['button_registration_' . $lang]) ? $options['button_registration_' . $lang] : ''); ?>" class="widefat">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Ссылка кнопки "Регистрация":', 'template_theme'); ?></th>
                                <td>
                                    <input type="text" name="template_theme_translate_options[button_registration_link_<?php echo esc_attr($lang); ?>]" value="<?php echo esc_attr(isset($options['button_registration_link_' . $lang]) ? $options['button_registration_link_' . $lang] : ''); ?>" class="widefat">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Заголовок 404:', 'template_theme'); ?></th>
                                <td>
                                    <input type="text" name="template_theme_translate_options[title_404_<?php echo esc_attr($lang); ?>]" value="<?php echo esc_attr(isset($options['title_404_' . $lang]) ? $options['title_404_' . $lang] : ''); ?>" class="widefat">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Текст кнопки "На главную" 404:', 'template_theme'); ?></th>
                                <td>
                                    <input type="text" name="template_theme_translate_options[button_home_404_<?php echo esc_attr($lang); ?>]" value="<?php echo esc_attr(isset($options['button_home_404_' . $lang]) ? $options['button_home_404_' . $lang] : ''); ?>" class="widefat">
                                </td>
                            </tr>
                            
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Текст уведомления 404:', 'template_theme'); ?></th>
                                <td>
                                    <textarea name="template_theme_translate_options[text_404_<?php echo esc_attr($lang); ?>]" class="widefat"><?php echo esc_textarea(isset($options['text_404_' . $lang]) ? $options['text_404_' . $lang] : ''); ?></textarea>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Фоновая картинка 404:', 'template_theme'); ?></th>
                                <td>
                                    <input type="text" name="template_theme_translate_options[bg_image_404_<?php echo esc_attr($lang); ?>]" value="<?php echo esc_attr(isset($options['bg_image_404_' . $lang]) ? $options['bg_image_404_' . $lang] : ''); ?>" class="widefat">
                                    <button type="button" class="upload_image_button button button-primary" data-target="template_theme_translate_options[bg_image_404_<?php echo esc_attr($lang); ?>]">Загрузить изображение</button>
                                    <?php if (isset($options['bg_image_404_' . $lang]) && $options['bg_image_404_' . $lang]): ?>
                                        <img src="<?php echo esc_url($options['bg_image_404_' . $lang]); ?>" alt="Background Image (<?php echo esc_attr($lang); ?>)" style="max-width: 100px;">
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; ?>

                <?php submit_button(__('Сохранить переводы', 'template_theme')); ?>
            </form>
        </div>
    </div>
    <script>
        jQuery(document).ready(function($) {
            // Обработчик клика ТОЛЬКО по ссылкам с классом 'language-tab-link'
            $('.nav-tab-wrapper a.language-tab-link').click(function(e) {
                e.preventDefault();
                var lang = $(this).data('lang');

                // Деактивируем все вкладки и скрываем все содержимое
                $('.nav-tab-wrapper a.language-tab-link').removeClass('nav-tab-active');
                $('.lang-tab-content').hide();

                // Активируем текущую вкладку и показываем соответствующее содержимое
                $(this).addClass('nav-tab-active');
                $('#lang-' + lang).show();
            });

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
    <style>
        .translate-settings-tabs .nav-tab-wrapper {
            margin-bottom: 20px;
        }
        .translate-settings-tabs .lang-tab-content {
            border: 1px solid #ccc;
            padding: 15px;
            background-color: #fff;
        }
    </style>
    <?php


