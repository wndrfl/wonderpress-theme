<?php
use Wonderpress\Partials\Image;

if (! function_exists('wonder_body_id')) {
	/**
	 * Stash a static record of the intended body id
	 *
	 * @param String $body_id The ID of the body tag.
	 */
	function wonder_body_id( $body_id = null ) {
		static $_body_id;

		if ( ! is_null( $body_id ) ) {
			$_body_id = $body_id;
			return;
		}

		return 'id="' . ( $_body_id ? $_body_id : 'body' ) . '"';
	}
}

if (! function_exists('wonder_image')) {
	/**
	 * Render or return the contents of a template file.
	 *
	 * @param String  $_filename The path to the file.
	 * @param Mixed[] $_params An array of variables to pass to the template.
	 * @param Boolean $_return Whether to return the contents (instead of echoing them).
	 */
	function wonder_image( $params, $echo = true ) {
		$image = new Image($params);
		$image->render($echo);
	}
}

if (! function_exists('wonder_include_template_file')) {
	/**
	 * Render or return the contents of a template file.
	 *
	 * @param String  $_filename The path to the file.
	 * @param Mixed[] $_params An array of variables to pass to the template.
	 * @param Boolean $_return Whether to return the contents (instead of echoing them).
	 */
	function wonder_include_template_file( $_filename, $_params = array(), $_return = false ) {
		if ( $_return ) {
			$html = '';
			ob_start();
		}

		foreach ( $_params as $k => $v ) {
			$$k = $v;
		}
		include( locate_template( $_filename ) );

		if ( $_return ) {
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
		}
	}
}

if (! function_exists('wonder_nav')) {
	/**
	 * Uses wp_nav_menu() to generate a new menu.
	 *
	 * @param String $location The name the navigation location to hook into.
	 */
	function wonder_nav( $location = 'header-menu' ) {
		wp_nav_menu(
			array(
				'theme_location'  => $location,
				'menu'            => '',
				'container'       => 'div',
				'container_class' => 'menu-container',
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
	}