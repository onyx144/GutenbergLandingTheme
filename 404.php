<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#404-not-found
 *
 * @package template_theme 
 */

get_header();
?>
<style>
.custom-banner {
    display: none;
}
</style>
	<main class="site-main">
    
    <section class="error-404 not-found" style="<?php
    $current_lang = function_exists('pll_current_language') ? pll_current_language() : 'uk';
    $bg_image_404 = get_option('template_theme_translate_options')['bg_image_404_' . $current_lang] ?? '';
    if (!empty($bg_image_404)) {
        echo 'background-image: url(' . esc_url($bg_image_404) . '); background-size: contain; background-repeat: no-repeat; background-position: center;';
    }
?>">
			<header class="page-header">
				<h1 class="page-title"><?php
					$title_404 = get_option('template_theme_translate_options')['title_404_' . $current_lang] ?? __('Страница не найдена', 'template_theme'); // Замените 'template_theme'
					echo esc_html($title_404);
				?></h1>
			</header><div class="page-content">
				<p><?php
					$text_404 = get_option('template_theme_translate_options')['text_404_' . $current_lang] ?? __('Похоже, ничего не было найдено по вашему запросу. Возможно, поиск поможет.', 'template_theme'); // Замените 'template_theme'
					echo esc_html($text_404);
				?></p>


				<div class="home-link">
					<a href="<?php
						$home_button_link = get_option('template_theme_translate_options')['button_home_404_link'] ?? home_url('/');
						echo esc_url($home_button_link);
					?>"><?php
						$home_button_text = get_option('template_theme_translate_options')['button_home_404_' . $current_lang] ?? __('На главную', 'template_theme'); // Замените 'template_theme'
						echo esc_html($home_button_text);
					?></a>
				</div>
			</div></section></main><?php
get_footer();