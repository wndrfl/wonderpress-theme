<?php
/**
 * Global functions.
 *
 * @package Wonderpress Theme
 */

/*
 * This lot auto-loads a class or trait just when you need it. You don't need to
 * use require, include or anything to get the class/trait files, as long
 * as they are stored in the correct folder and use the correct namespaces.
 *
 * See http://www.php-fig.org/psr/psr-4/ for an explanation of the file structure.
 */
spl_autoload_register(
	function ( $class_name ) {
		if ( false !== strpos( $class_name, 'Wonderpress' ) ) {
			$classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
			$class_file  = str_replace( 'Wonderpress\\', '', $class_name ) . '.php';
			$class_file  = str_replace( '\\', DIRECTORY_SEPARATOR, $class_file );
			// die($classes_dir . $class_file);
			require_once $classes_dir . $class_file;
		}
	}
);

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
require_all( dirname( __FILE__ ) . '/inc/' );


/**
 * Theme Support
 */

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
}


/**
 * Remove Various Actions
 */

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
