<?php
/**
 * Check for and recommend or require various plugins.
 *
 * @package Wonderpress Theme
 */

if( is_admin() && is_user_logged_in() && current_user_can('install_plugins') ) {

	// Check if needed functions exists - if not, require them
	if ( ! function_exists( 'get_plugins' ) || ! function_exists( 'is_plugin_active' ) ) {
	    require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	function wonder_get_required_plugins_that_are_not_installed_or_active() {

		$wonder_required_plugins = [
			'wonderpress-core/wonderpress-core.php' => [
				'name' => 'Wonderpress Core'
			],
		];

	    $requires_attention = [
	    	'to_activate' => [],
	    	'to_install' => []
	    ];

	    // Find plugins that need installation

	    $installed_plugins = get_plugins();

	    foreach ($wonder_required_plugins as $plugin_slug => $plugin_details) {
			if( ! array_key_exists( $plugin_slug, $installed_plugins ) ) {
				$requires_attention['to_install'][$plugin_slug] = $plugin_details;
			}
	    }

	    // Find plugins that need activation

	    $active_plugins = get_option('active_plugins');

	    foreach ($wonder_required_plugins as $plugin_slug => $plugin_details) {
			if( ! in_array( $plugin_slug, $active_plugins ) ) {
				$requires_attention['to_activate'][$plugin_slug] = $plugin_details;
			}
	    }

	    return $requires_attention;
	}

	function wonder_plugins_require_installation_notice() {

		$requires_attention = wonder_get_required_plugins_that_are_not_installed_or_active();

		// Display a message for plugins that need to be installed
		if($requires_attention['to_install']) { 
	    ?>
	    <div class="error notice">
	        <p>
	        	<?php _e( 'The following plugins must be <b>installed</b> for the Wonderpress Theme to operate as intended:', 'my_plugin_textdomain' ); ?>
        	</p>
	        <?php foreach($requires_attention['to_install'] as $plugin_slug => $plugin_details) { ?>
	        <p>
	        	- <?php echo esc_html( $plugin_details['name'] ); ?>
	        </p>
	        <?php } ?>
	    </div>
	    <?php
		}

		// Display a message for plugins that need to be activate
		if($requires_attention['to_activate']) { 
	    ?>
	    <div class="error notice">
	        <p>
	        	<?php _e( 'The following plugins must be <b>activated</b> for the Wonderpress Theme to operate as intended:', 'my_plugin_textdomain' ); ?>
        	</p>
	        <?php foreach($requires_attention['to_activate'] as $plugin_slug => $plugin_details) { ?>
	        <p>
	        	- <?php 
		        $link = wp_nonce_url(admin_url('plugins.php?action=activate&plugin='.$plugin_slug), 'activate-plugin_'.$plugin_slug);
		        echo esc_html( $plugin_details['name'] ) . ' <a href="' . esc_url( $link ) . '" title="Activate ' . esc_attr( $plugin_details['name'] ) . '">Activate</a>'; 
		        ?>
	        </p>
	        <?php } ?>
	    </div>
	    <?php
		}
	}
	add_action( 'admin_notices', 'wonder_plugins_require_installation_notice' );


	
}