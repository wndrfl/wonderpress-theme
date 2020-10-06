<?php
/**
 * Set image sizes for the WordPress CMS
 *
 * @package Wonderpress Theme
 */

if ( function_exists( 'add_theme_support' ) ) {
	add_image_size( 'large', 700, '', true );
	add_image_size( 'medium', 250, '', true );
	add_image_size( 'small', 120, '', true );
}
