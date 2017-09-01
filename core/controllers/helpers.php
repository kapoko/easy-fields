<?php 

namespace EasyFields\Controllers;

if (! class_exists('EasyFields\Controllers\Helpers')) :

class Helpers 
{
    function __construct()
    {
    }

    /**
     * Displays denied message if user is not admin
     * 
     * @return void
     */
    public static function deny_if_not_admin() 
    {
        if (! current_user_can('manage_options')) {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
    }
}

endif; // End class_exists check

new Helpers();