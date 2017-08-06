<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Caspian
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<?php if( caspian_is_sticky() ) :?>
			<div class="sticky-label">
				<?php echo caspian_get_svg( array( 'icon' => 'star' ) );?>
			</div>
		<?php endif;?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php caspian_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif;?>

		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		?>

		<?php if ( ! is_singular() && ! post_password_required() ) : ?>
			<div class="entry-media">
				<?php echo caspian_media_grabber( array( 'type' => 'video', 'split_media' => true ) );?>
			</div>
		<?php elseif( has_post_thumbnail() ) :?>
			<?php caspian_post_thumbnail();?>
		<?php endif;?>

	</header><!-- .entry-header -->

	<?php if( is_singular() || post_password_required() ) : ?>
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
	<?php else : ?>
	<div class="entry-summary">
		<?php the_excerpt();?>
	</div><!-- .entry-summary -->
	<?php endif;?>

	<footer class="entry-footer">
		<?php caspian_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
