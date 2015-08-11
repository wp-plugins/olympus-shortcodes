<?php
/*
Plugin Name: Olympus Shortcodes
Plugin URI: http://olympusthemes.com/toolkit
Description: Adds shortcodes you can use in your posts, pages and widgets.
Author: Olympus Themes
Author URI: http://olympusthemes.com
Version: 1.0.4
Text Domain: olympus-shortcodes
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

register_activation_hook( __FILE__, 'activate_olympus_shortcodes' );

/**
  * Plugin Activation hook function to check for conflicting plugin
  */
 function activate_olympus_shortcodes() {
     if(class_exists('Olympus_Newsletter')) {
    deactivate_plugins( basename( __FILE__ ) );
    wp_die('<p>Please deactivate Olympus Toolkit before enabling this plugin.</p>','Plugin Activation Error',  array( 'response'=>200, 'back_link'=>TRUE ) );
     }
}


/**
 * Main Olympus_Shortcode Class
 *
 * @since 1.0.0
 */
class Olympus_Shortcodes {

	/**
	 * Load plugin files
	 */
	function __construct() {

		add_action( 'init', array( $this, 'init' ) );
		
	}

	/**
	 * Register and Enqueue scripts and styles that may be used.
	 */
	public function init() {

		$scripts_dir = plugin_dir_url( __FILE__ );

		// Enqueue CSS.
		wp_enqueue_style( 'olympus-shortcode-styles', $scripts_dir . 'css/style.css' );
		wp_register_style( 'flexslider', $scripts_dir . 'css/flexslider.css' );
		wp_register_style( 'font-awesome', $scripts_dir . 'css/font-awesome.css' );

		// Make sure jquery is loaded.
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'jquery-ui-tabs' );

		// Register scripts.
		wp_register_script( 'google-maps', '//maps.googleapis.com/maps/api/js?sensor=false' );
		wp_register_script( 'flexslider', $scripts_dir . 'js/jquery.flexslider.js', 'jquery', '1.0', true );
		wp_register_script( 'olympus-shortcode-scripts', $scripts_dir . 'js/scripts.js', array( 'jquery', 'jquery-ui-tabs' ), '1.0', true );
		
		require_once( plugin_dir_path( __FILE__ ) .'includes/shortcode-functions.php' );

	}

}

$olympus_shortcodes = new Olympus_Shortcodes();
