<?php 

namespace EasyFields\Controllers;

use EasyFields\Controllers\Helpers;

if (! class_exists('EasyFields\Controllers\Scanner')) :

class Scanner 
{
    function __construct() 
    {
        // Actions
        add_action('wp_head', array($this, 'add_meta_tag'));
    }

    /**
     * Adds meta tag with the template path
     */
    public function add_meta_tag() 
    {
        $should_add_meta_tag = (isset($_REQUEST['easy-fields-meta-tag'])) ? $_REQUEST['easy-fields-meta-tag'] : 0;

        if ($should_add_meta_tag) {
            ob_start(); ?>
            
            <meta name="easy-fields-template-scanner" content="<?= self::get_template_path() ?>" />

            <?php echo ob_get_clean();
        }
    }

    /**
     * Takes a link to a post or page en finds the templates used. 
     * 
     * @param  int      $id     Post or page ID
     * @return array            Array containing filenames of used templates
     */
    public static function find_templates_used($permalink)
    {
        $url_with_parameter = \add_query_arg('easy-fields-meta-tag', 1, $permalink);

        $main_template_path = self::get_meta_tag($url_with_parameter, 'easy-fields-template-scanner');

        return array($main_template_path);
    }

    /**
     * Retrieves meta tag of choice from an url
     * 
     * @param  string $url           The external url
     * @param  string $meta_tag_name Meta tage name attribute
     * @return string                The content of that tag
     */
    public static function get_meta_tag($url, $meta_tag_name)
    {
        $html = self::file_get_contents_curl($url);

        $doc = new \DOMDocument();

        // loadHTML() gives a warning for HTML5 pages, surpress it
        libxml_use_internal_errors(true);
        @$doc->loadHTML($html);
        libxml_use_internal_errors(false);

        $metas = $doc->getElementsByTagName('meta');

        for ($i = 0; $i < $metas->length; $i++)
        {
            $meta = $metas->item($i);
            if($meta->getAttribute('name') == $meta_tag_name) {
                return $meta->getAttribute('content');
            }
        }

        return false;
    }

    /**
     * Gets contents of url using curl
     * 
     * @param  string $url The external url
     * @return string      String containing html
     */
    public static function file_get_contents_curl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * Gets the template path. Based on wp-includes/template-loader.php
     * Has to be executed inside a post loop.
     * 
     * @return string Template path.
     */
    public static function get_template_path() 
    {
        if ( defined('WP_USE_THEMES') && WP_USE_THEMES ) :
            $template = false;
            if     ( is_embed()             && $template = get_embed_template()             ) :
            elseif ( is_404()               && $template = get_404_template()               ) :
            elseif ( is_search()            && $template = get_search_template()            ) :
            elseif ( is_front_page()        && $template = get_front_page_template()        ) :
            elseif ( is_home()              && $template = get_home_template()              ) :
            elseif ( is_post_type_archive() && $template = get_post_type_archive_template() ) :
            elseif ( is_tax()               && $template = get_taxonomy_template()          ) :
            elseif ( is_attachment()        && $template = get_attachment_template()        ) :
                remove_filter('the_content', 'prepend_attachment');
            elseif ( is_single()            && $template = get_single_template()            ) :
            elseif ( is_page()              && $template = get_page_template()              ) :
            elseif ( is_singular()          && $template = get_singular_template()          ) :
            elseif ( is_category()          && $template = get_category_template()          ) :
            elseif ( is_tag()               && $template = get_tag_template()               ) :
            elseif ( is_author()            && $template = get_author_template()            ) :
            elseif ( is_date()              && $template = get_date_template()              ) :
            elseif ( is_archive()           && $template = get_archive_template()           ) :
            else :
                $template = get_index_template();
            endif;

            return $template;
        endif;

        return false;
    }
}

endif; // End class_exists check

new Scanner();