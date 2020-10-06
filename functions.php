<?php
/**
 * Global functions.
 *
 * @package Wonderpress Theme
 */

/**
 * Require all files in a directory.
 *
 * @param String $path The path to the directory (with trailing slash).
 */
function require_all( $path ) {
	foreach ( glob( $path . '*.php' ) as $filename ) {
		require_once $filename;
	}
}

/**
 * Import PHP files from ./lib/ directory
 */
require_all( dirname( __FILE__ ) . '/lib/' );


/**
 * Theme Support
 */

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
}

/**
 * Custom Post Types
 */

require_all( dirname( __FILE__ ) . '/lib/custom-post-types/' );

/**
 * Shortcodes
 */

require_all( dirname( __FILE__ ) . '/lib/shortcodes/' );


/**
 * Remove Various Actions
 */

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
