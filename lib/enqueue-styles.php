<?php
/**
 * Enqueue any stylesheets to be used in this theme.
 *
 * @package Wonderpress Theme
 */

/**
 * Enqueue styles
 */
function wonder_enqueue_styles() {

	// remove dashicons
	wp_deregister_style( 'dashicons' );

	wp_register_style( 'fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,700,300,600', array(), '1.0', 'all' );
	wp_enqueue_style( 'fonts' );

	$path = '/css/styles.css';
	$version = filemtime( get_template_directory() . $path );
	wp_register_style( 'theme', get_template_directory_uri() . $path, array(), $version, 'all' );
	wp_enqueue_style( 'theme' );
}

add_action( 'wp_enqueue_scripts', 'wonder_enqueue_styles' );
