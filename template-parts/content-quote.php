<?php
/**
 * Template part for displaying quote posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Caspian
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php caspian_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif;?>

		<?php the_title( '<h1 class="entry-title screen-reader-text">', '</h1>' );?>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'caspian' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'caspian' ),
				'after'  => '</div>',
			) );
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php caspian_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
