<?php
/**
 * Функция для отрисовки полей настроек.
 */
function template_theme_render_field( $args ) {
    $options = get_option( $args['option_name'] );
    $value = isset( $options[ $args['field_id'] ] ) ? $options[ $args['field_id'] ] : '';

    switch ( $args['type'] ) {
        case 'checkbox':
            printf(
                '<input type="checkbox" id="%s" name="%s[%s]" value="1" %s />',
                esc_attr( $args['label_for'] ),
                esc_attr( $args['option_name'] ),
                esc_attr( $args['field_id'] ),
                checked( '1', $value, false )
            );
            break;

        case 'text':
            printf(
                '<input type="text" id="%s" name="%s[%s]" value="%s" class="widefat" />',
                esc_attr( $args['label_for'] ),
                esc_attr( $args['option_name'] ),
                esc_attr( $args['field_id'] ),
                esc_attr( $value )
            );
            break;

        case 'image':
            ?>
            <input type="text" id="<?php echo esc_attr( $args['field_id'] ); ?>" name="<?php echo esc_attr( $args['option_name'] ); ?>[<?php echo esc_attr( $args['field_id'] ); ?>]" value="<?php echo esc_attr( $value ); ?>" class="widefat">
            <button class="upload_image_button button button-primary" data-target="<?php echo esc_attr( $args['field_id'] ); ?>">Загрузить изображение</button>
            <?php if ( $value ) : ?>
                <img src="<?php echo esc_url( $value ); ?>" style="max-width: 100px; max-height: 100px;">
            <?php endif; ?>
            <script>
                jQuery(document).ready(function($) {
                    $('.upload_image_button').click(function(e) {
                        e.preventDefault();
                        var target = $(this).data('target');
                        var image = wp.media({
                            title: 'Загрузить изображение',
                            multiple: false
                        }).open()
                        .on('select', function() {
                            var uploaded_image = image.state().get('selection').first();
                            var image_url = uploaded_image.toJSON().url;
                            $('#' + target).val(image_url);
                        });
                    });
                });
            </script>
            <?php
            break;

        // Добавьте другие типы полей, если необходимо
    }
}

function enqueue_admin_scripts($hook) {
    if ('toplevel_page_template_theme_settings' != $hook) {
        return;
    }
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'enqueue_admin_scripts');

function template_theme_add_favicon() {
    $options = get_option( 'template_theme_banner_options' );
    $favicon_url = isset( $options['favicon'] ) ? esc_url( $options['favicon'] ) : '';

    if ( ! empty( $favicon_url ) ) {
        echo '<link rel="icon" href="' . $favicon_url . '" type="image/x-icon" />';
        echo '<link rel="shortcut icon" href="' . $favicon_url . '" type="image/x-icon" />';
    }
}
add_action( 'wp_head', 'template_theme_add_favicon' );

?>