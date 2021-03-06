<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Caspian
 */

if ( ! function_exists( 'caspian_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function caspian_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	$byline = sprintf(
		/* translators: %s: post author. */
		esc_html_x( 'by %s', 'post author', 'caspian' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'caspian_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function caspian_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'caspian' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links">%s <span class="screen-reader-text">' . esc_html__( 'Posted in', 'caspian' ) . '</span> %s</span>',
			caspian_get_svg( array( 'icon' => 'category' ) ),
			$categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'caspian' ) );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<span class="tags-links">%s <span class="screen-reader-text">' . esc_html__( 'Tagged', 'caspian' ) . '</span> %s</span>',
			caspian_get_svg( array( 'icon' => 'tag' ) ),
			$tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		echo caspian_get_svg( array( 'icon' => 'comment' ) );
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'caspian' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'caspian' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

if ( !function_exists( 'caspian_posts_navigation' ) ) :
/**
 * [caspian_posts_navigation description]
 * @return [type] [description]
 */
function caspian_posts_navigation(){

	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
		return;
	}

	if ( get_theme_mod( 'posts_navigation', 'posts_navigation' ) == 'posts_navigation' ) {
		the_posts_navigation( array(
            'prev_text'          => __( '&larr; Older posts', 'caspian' ),
            'next_text'          => __( 'Newer posts &rarr;', 'caspian' ),
		) );
	} else {
		the_posts_pagination( array(
			'prev_text'          => sprintf( '%s <span class="screen-reader-text">%s</span>', caspian_get_svg( array( 'icon' => 'previous' ) ), __( 'Previous Page', 'caspian' ) ),
			'next_text'          => sprintf( '%s <span class="screen-reader-text">%s</span>', caspian_get_svg( array( 'icon' => 'next' ) ), __( 'Next Page', 'caspian' ) ),
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'caspian' ) . ' </span>',
		) );
	}

}
endif;

if ( ! function_exists( 'caspian_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 */
function caspian_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;

if ( ! function_exists( 'caspian_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index
 * views, or a div element when on single views.
 */
function caspian_post_thumbnail( $size = 'post-thumbnail') {

	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( ! is_singular() ) {
		echo '<div class="post-thumbnail">';
			echo '<a href="'. get_permalink( get_the_id() ) .'">';
				the_post_thumbnail( $size );
			echo '</a>';
		echo '</div>';
	}

}
endif;

if( ! function_exists( 'caspian_footer_copyright' ) ) :
/**
 * [caspian_footer_copyright description]
 * @return [type] [description]
 */
function caspian_get_footer_copyright(){
	$default_footer_copyright =	sprintf( __( 'Copyright &copy; %1$s %2$s. Proudly powered by %3$s.', 'caspian' ),
		date_i18n( __('Y', 'caspian' ) ),
		'<a href="'. esc_url( home_url() ) .'">'. esc_attr( get_bloginfo( 'name' ) ) .'</a>',
		'<a href="'. esc_url( 'https://wordpress.org/' ) .'">WordPress</a>' );

	apply_filters( 'caspian_footer_copyright', $default_footer_copyright );

	$footer_copyright = get_theme_mod( 'footer_copyright' );

	if ( !empty( $footer_copyright ) ) {
		$footer_copyright = str_replace( '[YEAR]', date_i18n( __('Y', 'caspian' ) ), $footer_copyright );
		$footer_copyright = str_replace( '[SITE]', '<a href="'. esc_url( home_url() ) .'">'. esc_attr( get_bloginfo( 'name' ) ) .'</a>', $footer_copyright );
		return htmlspecialchars_decode( esc_attr( $footer_copyright ) );
	} else {
		return $default_footer_copyright;
	}

}
endif;

if( ! function_exists( 'caspian_do_footer_copyright' ) ) :
/**
 * [caspian_do_footer_copyright description]
 * @return [type] [description]
 */
function caspian_do_footer_copyright(){

	echo '<div class="site-info">'. caspian_get_footer_copyright() . '</div>';
	if ( get_theme_mod( 'theme_designer', true )  == true ) {
		echo '<div class="site-designer">'. sprintf( __( 'Theme design by %s %s.', 'caspian' ), caspian_get_svg( array( 'icon' => 'campaignkit' ) ),'<a href="'. esc_url( 'https://campaignkit.co/' ) .'">Campaign Kit</a>' ) .'</div>';
	}
}
endif;

if ( ! function_exists( 'caspian_return_to_top' ) ) :
/**
 * [caspian_return_to_top description]
 * @return string
 */
function caspian_return_to_top(){
	if( get_theme_mod( 'return_top', true ) ) {
		echo '<a href="#page" class="return-to-top">'. caspian_get_svg( array( 'icon' => 'top' ) ) .'</a>';
	}
}
endif;
