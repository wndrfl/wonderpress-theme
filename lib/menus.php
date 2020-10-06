<?php
/**
 * Register all menu locations for the WordPress CMS
 *
 * @package Brass Tacks
 */

/**
 * Register nav menus
 */
function bt_register_menu() {
	register_nav_menus(
		array(
			'header-menu'  => 'Header Menu',
			'sidebar-menu' => 'Sidebar Menu',
			'footer-menu'  => 'Footer Menu',
		)
	);
}

add_action( 'init', 'bt_register_menu' );
