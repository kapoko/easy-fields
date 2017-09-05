<?php 

namespace EasyFields\Controllers;

use EasyFields\Controllers\Scanner;

if (! class_exists('EasyFields\Controllers\Admin')) :

class Admin 
{
    function __construct() 
    {
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('add_meta_boxes', array($this, 'admin_meta_boxes'));
    }

    /**
     * Register settings page
     * 
     * @return void
     */
    public function admin_menu() 
    {
        add_options_page( 'Easy Fields Settings', 'Easy Fields', 'manage_options', 'easy-fields', array($this, 'load_settings_view') );
    }

    /**
     * Load the settings view in the dashboard
     * 
     * @return void
     */
    public function load_settings_view() 
    {
        do_action('ef/helpers/deny_if_not_admin');
        require_once(sprintf('%s/core/views/settings.php', EF_DIR));
    }

    /**
     * Register the metabox
     * 
     * @return void
     */
    public function admin_meta_boxes() 
    {

        $args = array();

        add_meta_box(
            'ef_meta_box',
            __( 'Easy Fields', 'ef' ),
            array($this, 'load_meta_box_view'),
            array('post', 'page'),
            'normal',
            'high',
            $args
        );
    }

    /**
     * Load the metabox and pass the correct data to it. Invokes the scanner. 
     *
     * @return void
     */
    public function load_meta_box_view() 
    {
        $url = get_the_permalink();
        $template_urls = Scanner::find_templates_used($url);
        $fields = Reader::find_fields($template_urls);
        $data = $fields;

        require_once(sprintf('%s/core/views/meta_box.php', EF_DIR));
    }
}

endif; // End class_exists check

new Admin();