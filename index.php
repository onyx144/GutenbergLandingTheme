<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package template_theme
 */

get_header(); // Подключаем header.php
?>

    <main id="primary" class="site-main">

    
        <?php
        if ( have_posts() ) : // Проверяем, есть ли посты для вывода

            if ( is_home() && ! is_front_page() ) : // Если это страница блога (но не главная страница сайта)
                ?>
                <header>
                    <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                </header>
                <?php
            endif;

            /* Начало Цикла (The Loop) */
            while ( have_posts() ) :
                the_post(); // Устанавливает данные текущего поста

                /*
                 * Подключаем шаблон для контента поста (content.php).
                 * Если вам нужен разный вывод для разных форматов постов (напр., 'aside', 'gallery'),
                 * можно создать файлы content-aside.php, content-gallery.php и т.д.
                 * и использовать get_post_format() для их подключения.
                 * пока что используем просто get_template_part('template-parts/content', get_post_format());
                 * Для начала можно просто вывести заголовок и контент прямо здесь:
                 */
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php
                        if ( is_singular() ) : // Если это одиночная запись (пост или страница)
                            the_title( '<h1 class="entry-title">', '</h1>' );
                        else : // Если это архив или блог
                            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                        endif;
                        ?>
                    </header><div class="entry-content">
                        <?php
                        if ( is_singular( 'page' ) ) {
                            display_custom_toc( get_the_ID() );
                        }
                        if( is_singular() ){
                            
                             the_content( sprintf( // Выводим полный контент для одиночных записей
                                wp_kses(
                                    /* translators: %s: Name of current post. Only visible to screen readers */
                                    __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'template_theme' ),
                                    array(
                                        'span' => array(
                                            'class' => array(),
                                        ),
                                    )
                                ),
                                get_the_title()
                            ) );
                        } else {
                            the_excerpt(); // Выводим краткую выдержку (цитату) для архивов
                        }

                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'template_theme' ),
                            'after'  => '</div>',
                        ) );
                        ?>
                    </div><footer class="entry-footer">
                       <?php // Место для метаданных поста: дата, автор, категории, теги ?>
                    </footer></article><?php

            endwhile; /* Конец Цикла */

            the_posts_pagination(); // Вывод пагинации для списка постов (если постов много)

        else : // Если постов для вывода нет

            // Можно подключить шаблон для случая "ничего не найдено"
            // get_template_part( 'template-parts/content', 'none' );
            ?>
            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'template_theme' ); ?></h1>
                </header><div class="page-content">
                    <?php
                    if ( is_home() && current_user_can( 'publish_posts' ) ) : // Если пользователь может публиковать
                        printf(
                            '<p>' . wp_kses(
                                /* translators: 1: link to WP admin new post page. */
                                __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'template_theme' ),
                                array(
                                    'a' => array(
                                        'href' => array(),
                                    ),
                                )
                            ) . '</p>',
                            esc_url( admin_url( 'post-new.php' ) )
                        );
                    elseif ( is_search() ) : // Если это страница результатов поиска
                        ?>
                        <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'template_theme' ); ?></p>
                        <?php
                        get_search_form(); // Выводим форму поиска
                    else : // Во всех остальных случаях
                        ?>
                        <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'template_theme' ); ?></p>
                        <?php
                        get_search_form(); // Выводим форму поиска
                    endif;
                    ?>
                </div></section><?php
        endif;
        ?>

    </main><?php
// get_sidebar(); // Если вам нужен сайдбар, раскомментируйте и создайте файл sidebar.php
get_footer(); // Подключаем footer.php
?>