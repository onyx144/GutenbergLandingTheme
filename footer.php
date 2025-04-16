<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package template_theme
 */
?>
<?php
$popup_options = get_option('template_theme_popup_options');
$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'uk';
$lang_suffix = '_' . $current_lang;

if ($popup_options) {
    $popup_image = esc_url(isset($popup_options['popup_image' . $lang_suffix]) ? $popup_options['popup_image' . $lang_suffix] : (isset($popup_options['popup_image_uk']) ? $popup_options['popup_image_uk'] : ''));
    $popup_title = esc_html(isset($popup_options['popup_title' . $lang_suffix]) ? $popup_options['popup_title' . $lang_suffix] : (isset($popup_options['popup_title_uk']) ? $popup_options['popup_title_uk'] : ''));
    $popup_text = esc_html(isset($popup_options['popup_text' . $lang_suffix]) ? $popup_options['popup_text' . $lang_suffix] : (isset($popup_options['popup_text_uk']) ? $popup_options['popup_text_uk'] : ''));
    $popup_button_text = esc_html(isset($popup_options['popup_button_text' . $lang_suffix]) ? $popup_options['popup_button_text' . $lang_suffix] : (isset($popup_options['popup_button_text_uk']) ? $popup_options['popup_button_text_uk'] : ''));
    $popup_button_link = esc_url(isset($popup_options['popup_button_link' . $lang_suffix]) ? $popup_options['popup_button_link' . $lang_suffix] : (isset($popup_options['popup_button_link_uk']) ? $popup_options['popup_button_link_uk'] : ''));
    $popup_condition = esc_attr(isset($popup_options['popup_condition' . $lang_suffix]) ? $popup_options['popup_condition' . $lang_suffix] : (isset($popup_options['popup_condition_uk']) ? $popup_options['popup_condition_uk'] : 'timer'));
    $popup_condition_value = intval(isset($popup_options['popup_condition_value' . $lang_suffix]) ? $popup_options['popup_condition_value' . $lang_suffix] : (isset($popup_options['popup_condition_value_uk']) ? $popup_options['popup_condition_value_uk'] : 5));
    ?>

    <div id="template-theme-popup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid #ccc;">
        <span id="popup-close" style="position: absolute; top: 5px; right: 5px; cursor: pointer;">&times;</span>
        <?php if ($popup_image): ?>
            <img src="<?php echo $popup_image; ?>" alt="Pop-up Image" style="max-width: 100%;">
        <?php endif; ?>
        <h2><?php echo $popup_title; ?></h2>
        <p><?php echo $popup_text; ?></p>
        <a href="<?php echo $popup_button_link; ?>"><?php echo $popup_button_text; ?></a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var popup = document.getElementById('template-theme-popup');
            var closeButton = document.getElementById('popup-close');
            var condition = '<?php echo $popup_condition; ?>';
            var conditionValue = <?php echo $popup_condition_value; ?>;

            if (condition === 'timer') {
                setTimeout(function() {
                    popup.style.display = 'block';
                }, conditionValue * 1000);
            } else if (condition === 'scroll') {
                window.addEventListener('scroll', function() {
                    var scrollPercentage = (document.documentElement.scrollTop + document.body.scrollTop) / (document.documentElement.scrollHeight - document.documentElement.clientHeight) * 100;
                    if (scrollPercentage >= conditionValue) {
                        popup.style.display = 'block';
                    }
                });
            } else if (condition === 'wait_time') {
                setTimeout(function() {
                    popup.style.display = 'block';
                }, conditionValue * 1000);
            } else {
                popup.style.display = 'block';
            }

            closeButton.addEventListener('click', function() {
                popup.style.display = 'none';
            });
        });
    </script>
    <?php
}
?>
	</div><?php // Закрываем div#content, открытый в header.php ?>

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'template_theme' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'template_theme' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'template_theme' ), 'template_theme', '<a href="https://example.com/">Your Name or Company</a>' ); // Замените ссылку и имя автора
				?>
                <p>&copy; <?php echo date('Y'); // Выводим текущий год ?> <?php bloginfo('name'); // Выводим название сайта ?>. Все права защищены.</p>
		</div></footer></div><?php // Закрываем div#page, открытый в header.php ?>

<?php wp_footer(); // Важнейший хук! WordPress и плагины используют его для добавления скриптов и прочего перед закрытием </body> ?>

</body>
</html>