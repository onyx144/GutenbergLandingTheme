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