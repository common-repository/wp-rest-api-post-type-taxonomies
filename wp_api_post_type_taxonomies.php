<?php

/*
 Plugin Name: WP REST API - Post Type Taxonomies
 Plugin URI: http://magiks.ru
 Description: This plugin show all relations between post types and attached to them taxonomies in separate rest api end-point.
 Version: 1.0
 Author: Andrew MAGIK
 Author URI: http://magiks.ru/
 */


class post_type_taxonomies
{
    public function __construct()
    {
        $version = '2';
        $namespace = 'wp/v' . $version;
        $base = 'post-type-taxonomies';
        register_rest_route($namespace, '/' . $base, array(
            'methods' => 'GET',
            'callback' => array($this, 'get_post_type_taxonomies'),
        ));
    }

    public function get_post_type_taxonomies($object)
    {
        $return = array();
        $args = array(
            'public' => true
        );
        $post_types = get_post_types($args);
        foreach( $post_types as $post_type ){
            $taxonomies = get_object_taxonomies( $post_type );
            if (!empty($taxonomies)) {
                $return[$post_type] = $taxonomies;
            }
        }
        return new WP_REST_Response($return, 200);
    }
}

add_action('rest_api_init', function () {
    $post_type_taxonomies = new post_type_taxonomies;
});
