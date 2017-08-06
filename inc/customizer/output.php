<?php
/**
 * Caspian Theme Customizer Output
 *
 * @package Caspian
 */

/**
 * Print inline style
 *
 * @return string
 */
function caspian_add_inline_style(){

	$setting = caspian_setting_default();
	$primary_color 			= get_theme_mod( 'primary_color', $setting['primary_color'] );
	$secondary_color 		= get_theme_mod( 'secondary_color', $setting['secondary_color'] );

	$css= '';

	$primary_color_background_color = '
		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.screen-reader-text:focus,
		.comment-body > .reply a:hover,
		.comment-body > .reply a:focus,
		#cancel-comment-reply-link:hover,
		#cancel-comment-reply-link:focus,
		.widget_tag_cloud a:hover,
		.widget_tag_cloud a:focus,
		.instagram-follow-link a:hover,
		.instagram-follow-link a:focus,
		.return-to-top:hover,
		.return-to-top:focus
	';

	$primary_color_text_color = '
		a,
		.entry-meta a:hover,
		.entry-meta a:focus,
		.entry-title a:hover,
		.entry-title a:focus,
		.entry-footer a:hover,
		.entry-footer a:focus,
		.author-title a:hover,
		.author-title a:focus,
		.comment-meta a:hover,
		.comment-meta a:focus,
		.social-navigation a:hover,
		.social-navigation a:focus
	';

	$primary_color_border_color = '
		.comment-body > .reply a:hover,
		.comment-body > .reply a:focus,
		.page-numbers:hover:not(.current),
		.page-numbers:focus:not(.current),
		.widget_tag_cloud a:hover,
		.widget_tag_cloud a:focus,
		.instagram-follow-link a:hover,
		.instagram-follow-link a:focus,
		.return-to-top:hover,
		.return-to-top:focus
	';

	if ( $primary_color ) {
		$css .= sprintf( '%s{ background-color: %s }', $primary_color_background_color, esc_attr( $primary_color ) );
		$css .= sprintf( '%s{ color: %s }', $primary_color_text_color, esc_attr( $primary_color ) );
		$css .= sprintf( '%s{ border-color: %s }', $primary_color_border_color, esc_attr( $primary_color ) );
		$css .= sprintf( '::selection{background-color:%1$s}::-moz-selection{background-color:%1$s}', esc_attr( $primary_color ) );
	}

	$secondary_color_background_color = '
		button:hover,
		button:active,
		button:focus,
		input[type="button"]:hover,
		input[type="button"]:active,
		input[type="button"]:focus,
		input[type="reset"]:hover,
		input[type="reset"]:active,
		input[type="reset"]:focus,
		input[type="submit"]:hover,
		input[type="submit"]:active,
		input[type="submit"]:focus
	';
	$secondary_color_text_color = '
		a:hover,
		a:focus
	';

	if ( $secondary_color ) {
		$css .= sprintf( '%s{ background-color: %s }', $secondary_color_background_color, esc_attr( $secondary_color ) );
		$css .= sprintf( '%s{ color: %s }', $secondary_color_text_color, esc_attr( $secondary_color ) );
	}

	if ( get_theme_mod( 'post_date', $setting['post_date'] ) == false ) {
		$css .= '.entry-meta .posted-on{ display: none }';
	}

	if ( get_theme_mod( 'post_author', $setting['post_author'] ) == false ) {
		$css .= '.entry-meta .byline{ display: none }';
	}

	if ( get_theme_mod( 'post_cat', $setting['post_cat'] ) == false ) {
		$css .= '.entry-footer .cat-links{ display: none }';
	}

	if ( get_theme_mod( 'post_tag', $setting['post_tag'] ) == false ) {
		$css .= '.entry-footer .tags-links{ display: none }';
	}

	if ( get_theme_mod( 'post_comments', $setting['post_comments'] ) == false ) {
		$css .= '.entry-footer .comments-link{ display: none }';
	}


    $css = str_replace( array( "\n", "\t", "\r" ), '', $css );

	if ( ! empty( $css ) ) {
		wp_add_inline_style( 'caspian-style', apply_filters( 'caspian_inline_style', trim( $css ) ) );
	}

}
add_action( 'wp_enqueue_scripts', 'caspian_add_inline_style' );

/**
 * [caspian_customizer_style_placeholder description]
 * @return [type] [description]
 */
function caspian_customizer_style_placeholder(){
	if ( is_customize_preview() ) {
		echo '<style id="primary-color"></style>';
		echo '<style id="secondary-color"></style>';
	}
}
add_action( 'wp_head', 'caspian_customizer_style_placeholder', 15 );

/**
 * [caspian_editor_style description]
 * @param  [type] $mceInit [description]
 * @return [type]          [description]
 */
function caspian_editor_style( $mceInit ) {

	$setting = caspian_setting_default();
	$primary_color 			= get_theme_mod( 'primary_color', $setting['primary_color'] );
	$secondary_color 		= get_theme_mod( 'secondary_color', $setting['secondary_color'] );

	$styles = '';
	$styles .= '.mce-content-body a{ color: ' . esc_attr( $primary_color ) . '; }';
	$styles .= '.mce-content-body a:hover, .mce-content-body a:focus{ color: ' . esc_attr( $secondary_color ) . '; }';
	$styles .= '.mce-content-body ::selection{ background-color: ' . esc_attr( $secondary_color ) . '; }';
	$styles .= '.mce-content-body ::-mozselection{ background-color: ' . esc_attr( $secondary_color ) . '; }';

	$styles = str_replace( array( "\n", "\t", "\r" ), '', $styles );

	if ( !isset( $mceInit['content_style'] ) ) {
		$mceInit['content_style'] = trim( $styles ) . ' ';
	} else {
		$mceInit['content_style'] .= ' ' . trim( $styles ) . ' ';
	}

	return $mceInit;

}
add_filter( 'tiny_mce_before_init', 'caspian_editor_style' );
