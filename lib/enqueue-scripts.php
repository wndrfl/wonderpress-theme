<?php
/**
 * Enqueue any javascript files to be used in this theme.
 *
 * @package Wonderpress Theme
 */

/**
 * Enqueue scripts
 * These scrips will be added to the
 */
function wonder_enqueue_scripts() {
	if ( 'wp-login.php' !== $GLOBALS['pagenow'] && ! is_admin() ) {

		// Remove the built-in WordPress copy of jQuery
		wp_deregister_script( 'jquery' );

		// Replace with our own copy of jquery (and our custom scripts)
		$path = '/js/scripts.js';
		$version = filemtime( get_template_directory() . $path );
		wp_register_script( 'jquery', get_template_directory_uri() . $path, array(), $version, true );
		wp_enqueue_script( 'jquery' );
	}
}

add_action( 'init', 'wonder_enqueue_scripts' );
