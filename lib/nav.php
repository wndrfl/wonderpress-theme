<?php
/**
 * A custom WordPress navigation function to use with
 * WordPress menus.
 *
 * @package Brass Tacks
 */

/**
 * Uses wp_nav_menu() to generate a new menu.
 *
 * @param String $location The name the navigation location to hook into.
 */
function bt_nav( $location = 'header-menu' ) {
	wp_nav_menu(
		array(
			'theme_location'  => $location,
			'menu'            => '',
			'container'       => 'div',
			'container_class' => 'menu-{menu slug}-container',
			'container_id'    => '',
			'menu_class'      => 'menu',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul>%3$s</ul>',
			'depth'           => 0,
			'walker'          => '',
		)
	);
}
