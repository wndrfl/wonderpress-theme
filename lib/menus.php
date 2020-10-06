<?php
/**
 * Register all menu locations for the WordPress CMS
 *
 * @package Wonderpress Theme
 */

/**
 * Register nav menus
 */
function wonder_register_menu() {
	register_nav_menus(
		array(
			'header-menu'  => 'Header Menu',
			'sidebar-menu' => 'Sidebar Menu',
			'footer-menu'  => 'Footer Menu',
		)
	);
}

add_action( 'init', 'wonder_register_menu' );
