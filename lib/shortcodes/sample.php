<?php
/**
 * Create a sample shortcode for use in the WordPress WYSIWYG
 *
 * @package Brass Tacks
 */

/**
 * Will enable the user to place [bt_shortcode_sample]
 * in Pages and Posts. The output will be wrapped in and <h2>
 *
 * @param mixed[] $atts Array of attributes inside the shortcode tag.
 * @param String  $content The string that was wrapped in the shortcode tags.
 */
function bt_shortcode_sample( $atts, $content = null ) {
	return '<h2>' . $content . '</h2>';
}

add_shortcode( 'bt_shortcode_sample', 'bt_shortcode_sample' );
