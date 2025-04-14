<?php
function custom_blocks_register_settings() {
    register_setting(
        'custom_blocks_options_group',
        'custom_blocks_options',
        'custom_blocks_sanitize_options'
    );

    add_settings_section(
        'custom_blocks_main_section',
        'Создание блоков',
        'custom_blocks_main_section_callback',
        'custom-blocks'
    );

    add_settings_field(
        'custom_blocks_fields',
        'Блоки',
        'custom_blocks_fields_callback',
        'custom-blocks',
        'custom_blocks_main_section'
    );
}
add_action('admin_init', 'custom_blocks_register_settings');

/**
 * Callback-функция для описания секции.
 */
function custom_blocks_main_section_callback() {
    echo '<p>Создайте блоки с изображениями и текстом.</p>';
}

/**
 * Callback-функция для полей блоков.
 */
function custom_blocks_fields_callback($args) {
    $options = get_option('custom_blocks_options');
    $blocks = isset($options['blocks']) ? $options['blocks'] : array();

    ?>
    <div id="custom_blocks_container">
        <?php
        if (!empty($blocks) && is_array($blocks)) {
            foreach ($blocks as $index => $block) {
                ?>
                <div class="custom_block">
                    <h3>Блок <?php echo $index + 1; ?></h3>
                    <label>Изображение слева:</label>
                    <input type="text" name="custom_blocks_options[blocks][<?php echo $index; ?>][image_left]" value="<?php echo esc_attr($block['image_left']); ?>" class="widefat">
                    <button type="button" class="upload_image_button button button-primary" data-target="custom_blocks_options[blocks][<?php echo $index; ?>][image_left]">Загрузить изображение</button>
                    <label>Текст под изображением слева:</label>
                    <textarea name="custom_blocks_options[blocks][<?php echo $index; ?>][text_left]" class="widefat"><?php echo esc_textarea($block['text_left']); ?></textarea>
                    <label>Текст по центру:</label>
                    <textarea name="custom_blocks_options[blocks][<?php echo $index; ?>][text_center]" class="widefat"><?php echo esc_textarea($block['text_center']); ?></textarea>
                    <label>Изображение справа:</label>
                    <input type="text" name="custom_blocks_options[blocks][<?php echo $index; ?>][image_right]" value="<?php echo esc_attr($block['image_right']); ?>" class="widefat">
                    <button type="button" class="upload_image_button button button-primary" data-target="custom_blocks_options[blocks][<?php echo $index; ?>][image_right]">Загрузить изображение</button>
                    <label>Текст под изображением справа:</label>
                    <textarea name="custom_blocks_options[blocks][<?php echo $index; ?>][text_right]" class="widefat"><?php echo esc_textarea($block['text_right']); ?></textarea>
                    <label>Цвет:</label>
                    <input type="color" name="custom_blocks_options[blocks][<?php echo $index; ?>][color]" value="<?php echo esc_attr($block['color']); ?>" class="widefat">
                    <label>Ссылка кнопки:</label>
                    <input type="text" name="custom_blocks_options[blocks][<?php echo $index; ?>][button_link]" value="<?php echo esc_attr($block['button_link']); ?>" class="widefat">
                    <label>Текст кнопки:</label>
                    <input type="text" name="custom_blocks_options[blocks][<?php echo $index; ?>][button_text]" value="<?php echo esc_attr($block['button_text']); ?>" class="widefat">
                    <button type="button" class="remove_custom_block">Удалить блок</button>
                </div>
                <?php
            }
        }
        ?>
        <button type="button" id="add_custom_block">Добавить блок</button>
    </div>

    <script>
        jQuery(document).ready(function($) {
            $('#add_custom_block').click(function() {
                var index = $('.custom_block').length;
                $('#custom_blocks_container').append('<div class="custom_block"><h3>Блок ' + (index + 1) + '</h3><label>Изображение слева:</label><input type="text" name="custom_blocks_options[blocks][' + index + '][image_left]" class="widefat"><button type="button" class="upload_image_button button button-primary" data-target="custom_blocks_options[blocks][' + index + '][image_left]">Загрузить изображение</button><label>Текст под изображением слева:</label><textarea name="custom_blocks_options[blocks][' + index + '][text_left]" class="widefat"></textarea><label>Текст по центру:</label><textarea name="custom_blocks_options[blocks][' + index + '][text_center]" class="widefat"></textarea><label>Изображение справа:</label><input type="text" name="custom_blocks_options[blocks][' + index + '][image_right]" class="widefat"><button type="button" class="upload_image_button button button-primary" data-target="custom_blocks_options[blocks][' + index + '][image_right]">Загрузить изображение</button><label>Текст под изображением справа:</label><textarea name="custom_blocks_options[blocks][' + index + '][text_right]" class="widefat"></textarea><label>Цвет:</label><input type="color" name="custom_blocks_options[blocks][' + index + '][color]" class="widefat"><label>Ссылка кнопки:</label><input type="text" name="custom_blocks_options[blocks][' + index + '][button_link]" class="widefat"><label>Текст кнопки:</label><input type="text" name="custom_blocks_options[blocks][' + index + '][button_text]" class="widefat"><button type="button" class="remove_custom_block">Удалить блок</button></div>');
            });

            $(document).on('click', '.remove_custom_block', function() {
                $(this).closest('.custom_block').remove();
            });

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
}

/**
 * Функция очистки данных перед сохранением.
 */
function custom_blocks_sanitize_options($input) {
    $sanitized = array();
    if (isset($input['blocks']) && is_array($input['blocks'])) {
        foreach ($input['blocks'] as $block) {
            $sanitized['blocks'][] = array(
                'image_left' => esc_url_raw($block['image_left']),
                'text_left' => sanitize_textarea_field($block['text_left']),
                'text_center' => sanitize_textarea_field($block['text_center']),
                'image_right' => esc_url_raw($block['image_right']),
                'text_right' => sanitize_textarea_field($block['text_right']),
                'color' => sanitize_text_field($block['color']),
                'button_link' => sanitize_text_field($block['button_link']),
                'button_text' => sanitize_text_field($block['button_text'])
            );
        }
    }
    return $sanitized;
}

function custom_blocks_shortcode($atts) {
    $atts = shortcode_atts(array(
        'ids' => '',
    ), $atts);

    $ids = explode(',', $atts['ids']);
    $blocks = get_option('custom_blocks_options');
    $output = '';

    if (!empty($blocks['blocks']) && is_array($blocks['blocks'])) {
        foreach ($ids as $id) {
            $id = intval(trim($id));
            if (isset($blocks['blocks'][$id - 1])) {
                $block = $blocks['blocks'][$id - 1];

                $output .= '<div class="custom_block_output" >';
                $output .= '
                   <div class="flex left">
                    <div class="image_left">
                        <img src="' . esc_url($block['image_left']) . '" alt="">
                    </div>
                    <div class="text_left">
                        ' . wp_kses_post($block['text_left']) . '
                    </div>
                    </div>
                    <div class="text_center">
                        ' . wp_kses_post($block['text_center']) . '
                    </div>
                    <div class="flex right">
                    <div class="image_right">
                        <img src="' . esc_url($block['image_right']) . '" alt="">
                    </div>
                    <div class="text_right">
                        ' . wp_kses_post($block['text_right']) . '
                    </div>
                    <div class="button_link" style="background-color: ' . esc_attr($block['color']) . ';>
                        <a href="' . esc_url($block['button_link']) . '">' . wp_kses_post($block['button_text']) . '</a>
                    </div>
                    </div>
                </div>';
            }
        }
    }

    return $output;
}
add_shortcode('blocks', 'custom_blocks_shortcode');
?>