<?php
function custom_toc_add_meta_box() {
    add_meta_box(
        'custom_toc_meta_box',
        'Настройки пользовательского ТОС',
        'custom_toc_meta_box_callback',
        'page',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'custom_toc_add_meta_box');

function custom_toc_meta_box_callback($post) {
    wp_nonce_field('custom_toc_save_meta_box_data', 'custom_toc_meta_box_nonce');

    $enabled = get_post_meta($post->ID, '_custom_toc_enabled', true);
    $items = get_post_meta($post->ID, '_custom_toc_items', true);

    ?>
    <label for="custom_toc_enabled">Включить пользовательский ТОС:</label>
    <input type="checkbox" id="custom_toc_enabled" name="custom_toc_enabled" <?php checked($enabled, 'on'); ?>>

    <div id="custom_toc_items_container">
        <?php
        if (!empty($items) && is_array($items)) {
            foreach ($items as $item) {
                ?>
                <div class="custom_toc_item">
                    <label>Заголовок:</label>
                    <input type="text" name="custom_toc_items[title][]" value="<?php echo esc_attr($item['title']); ?>">
                    <label>Ссылка:</label>
                    <input type="text" name="custom_toc_items[link][]" value="<?php echo esc_attr($item['link']); ?>">
                </div>
                <?php
            }
        }
        ?>
        <button type="button" id="add_custom_toc_item">Добавить пункт</button>
    </div>

    <script>
        jQuery(document).ready(function($) {
            $('#add_custom_toc_item').click(function() {
                $('#custom_toc_items_container').append('<div class="custom_toc_item"><label>Заголовок:</label><input type="text" name="custom_toc_items[title][]"><label>Ссылка:</label><input type="text" name="custom_toc_items[link][]"></div>');
            });
        });
    </script>
    <?php
}

function custom_toc_save_meta_box_data($post_id) {
    if (!isset($_POST['custom_toc_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['custom_toc_meta_box_nonce'], 'custom_toc_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    if (isset($_POST['custom_toc_enabled'])) {
        update_post_meta($post_id, '_custom_toc_enabled', 'on');
    } else {
        update_post_meta($post_id, '_custom_toc_enabled', 'off');
    }

    if (isset($_POST['custom_toc_items'])) {
        update_post_meta($post_id, '_custom_toc_items', $_POST['custom_toc_items']);
    }
}
add_action('save_post', 'custom_toc_save_meta_box_data');

function display_custom_toc($post_id) {
    $enabled = get_post_meta($post_id, '_custom_toc_enabled', true);
    $items = get_post_meta($post_id, '_custom_toc_items', true);

    if ($enabled === 'on' && !empty($items) && is_array($items)) {
        echo '<div id="custom_toc">';
        echo '<h3>Содержание</h3>';
        echo '<ul>';
        foreach ($items as $item) {
            echo '<li><a href="' . esc_url($item['link']) . '">' . esc_html($item['title']) . '</a></li>';
        }
        echo '</ul>';
        echo '</div>';
    }
}//
?>

