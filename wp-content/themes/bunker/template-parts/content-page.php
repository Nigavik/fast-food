<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bunker-food
 */

if (is_checkout()) {
	echo '<div class="container">';
	the_content();
	echo '</div>';
	
} else {
?>
	<div class="container">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			</header><!-- .entry-header -->

			<?php bunker_post_thumbnail(); ?>

			<div class="entry-content">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__('Pages:', 'bunker'),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->


		</article><!-- #post-<?php the_ID(); ?> -->
	</div>
<?php }
?>