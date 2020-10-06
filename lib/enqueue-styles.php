<?php
/**
 * Enqueue any stylesheets to be used in this theme.
 *
 * @package Brass Tacks
 */

/**
 * Enqueue styles
 */
function bt_enqueue_styles() {

	// remove dashicons
	wp_deregister_style( 'dashicons' );

	wp_register_style( 'fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,700,300,600', array(), '1.0', 'all' );
	wp_enqueue_style( 'fonts' );

	wp_register_style( 'theme', get_template_directory_uri() . '/css/styles.css', array(), '1.0', 'all' );
	wp_enqueue_style( 'theme' ); // Enqueue it!
}

add_action( 'wp_enqueue_scripts', 'bt_enqueue_styles' );
