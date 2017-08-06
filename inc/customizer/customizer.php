<?php
/**
 * Caspian Theme Customizer
 *
 * @package Caspian
 */

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function caspian_customize_preview_js() {
	wp_enqueue_script( 'caspian_customizer', get_template_directory_uri() . '/assets/js/customizer.min.js', array( 'customize-preview', 'customize-selective-refresh' ), '20151215', true );
}
add_action( 'customize_preview_init', 'caspian_customize_preview_js' );

/**
 * [caspian_setting_default description]
 * @return [type] [description]
 */
function caspian_setting_default(){
	$settings = array(
		'primary_color'		=> '#ff5722',
		'secondary_color'	=> '#e64a19',
		'post_date'			=> true,
		'post_author'		=> true,
		'post_cat'			=> true,
		'post_tag'			=> true,
		'post_comments'		=> true,
		'author_display'	=> true,
		'excerpt_length'	=> 20,
		'posts_navigation'	=> 'posts_navigation',
	);

	return apply_filters( 'caspian_setting_default', $settings );
}

/**
 * Load Customizer Setting.
 */
require get_template_directory() . '/inc/customizer/sanitization-callbacks.php';
require get_template_directory() . '/inc/customizer/settings.php';
require get_template_directory() . '/inc/customizer/output.php';
