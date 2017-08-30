<?php 

namespace EasyFields\Controllers;

if (! class_exists('EasyFields\Controllers\Admin')) :

class Admin 
{
    function __construct() 
    {
        add_action('admin_menu', array($this, 'admin_menu'));
    }

    public function admin_menu() 
    {
        add_options_page( 'Easy Fields Settings', 'Easy Fields', 'manage_options', 'easy-fields', array($this, 'load_settings_view') );
    }

    public function load_settings_view() 
    {
        do_action('ef/helpers/deny_if_not_admin');
        require_once(sprintf('%s/core/views/settings.php', EF_DIR));
    }
}

endif; // End class_exists check

new Admin();