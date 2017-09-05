<?php 

namespace EasyFields\Controllers;

if (! class_exists('EasyFields\Controllers\Reader')) :

class Reader
{
    /**
     * Reads php files and finds the fields using regex
     * 
     * @param  array $template_urls Array containing urls 
     * @return array                Array containing all the ef_field functions and their arguments
     */
    public static function find_fields($template_urls) 
    {
        $fields = [];

        foreach($template_urls as $url) {
            $file = file_get_contents($url);

            $pattern = '/ef_field\s?\((.*)\)/';

            preg_match_all($pattern, $file, $matches);


            $keys = array('key', 'type');

            foreach($matches[1] as $key => $match) {
                $arguments = self::split_arguments($match);

                array_push($fields, array_combine(array_slice($keys, 0, count($arguments)), $arguments));
            }
        }

        return $fields;
    }

    private static function split_arguments($arguments_string) 
    {
        $pattern = '/[\'"]([^\'"]*)[\'"]/';
        preg_match_all($pattern, $arguments_string, $matches);

        return $matches[1];
    }
} 

endif; // End class_exists check