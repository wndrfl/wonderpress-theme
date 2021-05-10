<?php
/**
 * Various functions and configurations to run upon page load.
 *
 * @package Wonderpress Theme
 */

/**
 * Set image sizes for the WordPress CMS
 */
if ( function_exists( 'add_theme_support' ) ) {
	add_image_size( 'banner', 2048, '', true );
	add_image_size( 'large', 1024, '', true );
	add_image_size( 'medium', 768, '', true );
	add_image_size( 'small', 120, '', true );
}


/**
 * Adds the slug of the current page or post as a class to the <body> tag
 * Extract the slug and add it to the classes[] array.
 *
 * @param mixed[] $classes An array of classes for the body tag.
 */
function wonder_add_slug_to_body_class( $classes ) {
	global $post;
	if ( is_home() ) {
		$key = array_search( 'blog', $classes, true );
		if ( $key > -1 ) {
			unset( $classes[ $key ] );
		}
	} elseif ( is_page() ) {
		$classes[] = sanitize_html_class( $post->post_name );
	} elseif ( is_singular() ) {
		$classes[] = sanitize_html_class( $post->post_name );
	}

	return $classes;
}

add_filter( 'body_class', 'wonder_add_slug_to_body_class' );


/**
 * Enqueue any javascript files to be used in this theme.
 * These scripts will be added to the header or footer.
 */
function wonder_enqueue_scripts() {
	if ( 'wp-login.php' !== $GLOBALS['pagenow'] && ! is_admin() ) {

		// Remove the built-in WordPress copy of jQuery
		wp_deregister_script( 'jquery' );

		// Replace with our own copy of jquery (and our custom scripts)
		$path = '/js/scripts.js';
		$version = filemtime( get_template_directory() . $path );
		wp_register_script( 'jquery', get_template_directory_uri() . $path, array(), $version, true );
		wp_enqueue_script( 'jquery' );
	}
}

add_action( 'init', 'wonder_enqueue_scripts' );


/**
 * Enqueue any stylesheets to be used in this theme.
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

/**
 * Will remove the admin bar.
 */
function wonder_remove_admin_bar() {
	return false;
}

add_filter( 'show_admin_bar', 'wonder_remove_admin_bar' );


/**
 * Remove recent_comments_style from wp_head
 */
function wonder_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action(
		'wp_head',
		array(
			$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
			'recent_comments_style',
		)
	);
}

add_action( 'widgets_init', 'wonder_remove_recent_comments_style' );








/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */

add_action( 'tgmpa_register', 'wonder_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function wonder_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin bundled with a theme.
		array(
			'name' 		=> 'Advanced Custom Fields',
			'slug' 		=> 'advanced-custom-fields',
			'required' 	=> false,
			'is_callable' => 'get_field',
		),

		// This is an example of the use of 'is_callable' functionality. A user could - for instance -
		// have WPSEO installed *or* WPSEO Premium. The slug would in that last case be different, i.e.
		// 'wordpress-seo-premium'.
		// By setting 'is_callable' to either a function from that plugin or a class method
		// `array( 'class', 'method' )` similar to how you hook in to actions and filters, TGMPA can still
		// recognize the plugin as being installed.
		array(
			'name'        => 'WordPress SEO by Yoast',
			'slug'        => 'wordpress-seo',
			'is_callable' => 'wpseo_init',
		),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'wonder',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'wonder-install-plugins', // Menu slug.
		'parent_slug'  => 'plugins.php',            // Parent menu slug.
		'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		/*
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'wonder' ),
			'menu_title'                      => __( 'Install Plugins', 'wonder' ),
			/* translators: %s: plugin name. * /
			'installing'                      => __( 'Installing Plugin: %s', 'wonder' ),
			/* translators: %s: plugin name. * /
			'updating'                        => __( 'Updating Plugin: %s', 'wonder' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'wonder' ),
			'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'wonder'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'wonder'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'wonder'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). * /
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'wonder'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'wonder'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'wonder'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'wonder'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'wonder'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'wonder'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'wonder' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'wonder' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'wonder' ),
			/* translators: 1: plugin name. * /
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'wonder' ),
			/* translators: 1: plugin name. * /
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'wonder' ),
			/* translators: 1: dashboard link. * /
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'wonder' ),
			'dismiss'                         => __( 'Dismiss this notice', 'wonder' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'wonder' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'wonder' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
		*/
	);

	tgmpa( $plugins, $config );
}
