<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 *
 * @package Caspian
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 */
function caspian_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'type'      		=> 'click',
		'container' 		=> 'main',
		'render'    		=> 'caspian_infinite_scroll_render',
		'footer_widgets'	=> array( 'sidebar-1' ),
	) );
}
add_action( 'after_setup_theme', 'caspian_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function caspian_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'template-parts/content', 'search' );
		else :
			get_template_part( 'template-parts/content', get_post_format() );
		endif;
	}
}

/** Remove Jetpack Infinity Scroll CSS */
function caspian_deregister_jetpack_styles(){
	wp_deregister_style( 'the-neverending-homepage' );
}
add_action( 'wp_print_styles', 'caspian_deregister_jetpack_styles' );
