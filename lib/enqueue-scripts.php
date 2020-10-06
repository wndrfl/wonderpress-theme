<?php
/**
 * Enqueue any javascript files to be used in this theme.
 *
 * @package Brass Tacks
 */

/**
 * Enqueue scripts
 * These scrips will be added to the
 */
function bt_enqueue_scripts() {
	if ( 'wp-login.php' !== $GLOBALS['pagenow'] && ! is_admin() ) {

		// Remove the built-in WordPress copy of jQuery
		wp_deregister_script( 'jquery' );

		// Replace with our own copy of jquery (and our custom scripts)
		wp_register_script( 'jquery', get_template_directory_uri() . '/js/scripts.min.js', array(), '1.0.0', true );
		wp_enqueue_script( 'jquery' );
	}
}

add_action( 'init', 'bt_enqueue_scripts' );
