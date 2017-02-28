<?php 
/*
Plugin Name: Easy Fields
Description: Quick and easy custom field creation, directly from template files
Author: Kasper Koman
Version: 0.1
License: Private
*/

define( 'EF_VERSION', '0.1' );

define( 'EF_PLUGIN', __FILE__ );

if ( !class_exists('EasyFields') ) {
	
	class EasyFields {

		var $settings;

		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{
			// Settings
			$this->settings = array(
				'field_prefix' => 'ef_'
			);

			// Filters
			add_filter( 'ef/get_settings', array( $this, 'get_settings' ), 1, 1);

		}

		/**
		 * Activate the plugin
		 */
		public static function activate()
		{

		}

		/**
		 * Deactivate the plugin
		 */
		public static function deactivate()
		{

		}

		/**
		 * Returns the plugins settings
		 * 
		 * @return 	mixed 	Returns array of settings without arguments, or a single setting
		 */
		public function get_settings( $s ) {
			$return = false;

			// If a single setting is chosen, only choose that setting
			if ( isset( $this->settings[ $s ] ) ) {
				$return = $this->settings[ $s ];

			// If all is given as argument, return all settings
			} else if ( $s = 'all' ) {			
				$return = $this->settings; 
			}

			return $return;
		}
	}
}

if ( class_exists('EasyFields') ) {
	global $ef;

    // Installation and uninstallation hooks
    register_activation_hook( EF_PLUGIN, array( 'EasyFields', 'activate' ) );
    register_deactivation_hook( EF_PLUGIN, array( 'EasyFields', 'deactivate' ) );

    // Instantiate the plugin class
    $ef = new EasyFields();
}