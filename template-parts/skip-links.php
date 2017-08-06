<?php
/**
 * Skip links
 *
 * @package Caspian
 */
?>

<?php if( has_nav_menu( 'menu-1' ) ) :?>
	<a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_html_e( 'Skip to navigation', 'caspian' ); ?></a>
<?php endif;?>

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'caspian' ); ?></a>

<?php if( is_active_sidebar( 'sidebar-1' ) ) :?>
	<a class="skip-link screen-reader-text" href="#secondary"><?php esc_html_e( 'Skip to Footer', 'caspian' ); ?></a>
<?php endif;?>
