<?php
/**
 * Template part for displaying gallery posts
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

		$gallery = get_post_gallery( get_the_ID(), false );
		$ids = explode( ",", $gallery['ids'] );
		if ( ! is_singular() && ! post_password_required() && !empty( $gallery ) ) {
			echo '<div class="entry-media">';
				echo '<div id="gallery-'. get_the_id() .'" class="entry-gallery">';
				foreach( $ids as $id ) {
					$image   	= wp_get_attachment_image( $id, 'post-thumbnail' );
					$image_src  = wp_get_attachment_image_src( $id, 'full' );
					$image_link = get_permalink( $id );
					echo sprintf( '<a href="%s" data-source="%s" title="%s">%s</a>', $image_src[0], $image_link, get_the_title( $id ), $image );
				}
				echo '</div>';
			echo '</div>';
		}
		?>

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
