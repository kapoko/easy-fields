<?php 

namespace EasyFields\Controllers;

if (! class_exists('EasyFields\Controllers\Helpers')) :

class Helpers 
{
    function __construct()
    {
        // Actions
        add_action('ef/helpers/deny_if_not_admin', array($this, 'deny_if_not_admin'));
    }

    /**
     * Displays denied message if user is not admin
     * 
     * @return void
     */
    public function deny_if_not_admin() 
    {
        if (! current_user_can('manage_options')) {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
    }
}

endif; // End class_exists check

new Helpers();