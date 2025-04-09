<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package template_theme
 */
?>
<!doctype html>
<html <?php language_attributes(); // Выводит атрибуты языка (напр., lang="ru-RU") ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); // Выводит кодировку сайта ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); // Важнейший хук! WordPress и плагины используют его для добавления стилей, скриптов, мета-тегов и т.д. в <head> ?>
</head>

<body <?php body_class(); // Добавляет различные CSS-классы к тегу body (напр., logged-in, admin-bar) ?>>
<?php wp_body_open(); // Хук для плагинов, срабатывает сразу после открытия <body> ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'template_theme' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			// Вывод логотипа или названия сайта
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$template_theme_description = get_bloginfo( 'description', 'display' );
			if ( $template_theme_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $template_theme_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'template_theme' ); ?></button>
			<?php
			// Вывод основного меню (если оно зарегистрировано в functions.php и создано в админке)
			wp_nav_menu(
				array(
					'theme_location' => 'primary', // 'primary' - это ID, который мы зададим в functions.php
					'menu_id'        => 'primary-menu',
				)
			);
			?>
		</nav></header><div id="content" class="site-content">
        <?php // Основной контент страницы начнется здесь (в index.php, page.php и т.д.) ?>