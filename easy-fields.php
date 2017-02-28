<?php 
/*
Plugin Name: Easy Fields
Description: Super easy and programmable custom fields for Wordpress.
Author: Kasper Koman
Version: 0.1
License: GPL-3.0
*/

namespace EasyFields;

define('EF_VERSION', '0.1');

define('EF_PLUGIN', __FILE__);

if (! class_exists('EasyFields')) :
	
class EasyFields 
{
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
		add_filter('ef/get_settings', array($this, 'get_settings'), 1, 1);
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
	 * @return 	mixed 	Returns array of settings or a single setting
	 */
	public function get_settings($setting) 
	{
		$result = false;

		// If a single setting is chosen, only choose that setting
		if (isset($this->settings[$setting])) {
			$result = $this->settings[$setting];
		} else if ($setting = 'all') {			
			$result = $this->settings; 
		}

		return $result;
	}
}

endif; // End class_exists check

/**
 * Create instance of a class with activation and deactivation hooks
 */
if ( class_exists('EasyFields') ) {
	global $ef;

    register_activation_hook( EF_PLUGIN, array( 'EasyFields', 'activate' ) );
    register_deactivation_hook( EF_PLUGIN, array( 'EasyFields', 'deactivate' ) );

    $ef = new EasyFields();
}