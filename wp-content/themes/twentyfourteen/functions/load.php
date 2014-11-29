<?php

class Load extends Extended_Object {

    // Post Type Label vars
    static $object_slug        = "load";
    static $object_name        = "Load";
    static $object_name_plural = "Loads";

    function __construct() {}

    public static function factory() { return new Load; }

    public function add_actions() {
        add_action('init', array($this, 'request_handler'));
        add_action('init', array($this, 'add_custom_post_type'));
    }

    public function request_handler() {}

    public function add_custom_post_type() {
        $labels = array(
            'name'               => __(self::$object_name)
           ,'singular_name'      => __(self::$object_name)
           ,'add_new'            => __('Add New')
           ,'add_new_item'       => __('Add New '.self::$object_name)
           ,'edit_item'          => __('Edit '.self::$object_name)
           ,'new_item'           => __('New '.self::$object_name)
           ,'all_items'          => __('All '.self::$object_name_plural)
           ,'view_items'         => __('View '.self::$object_name_plural)
           ,'search_items'       => __('Search '.self::$object_name_plural)
           ,'not_found'          => __('No '.self::$object_name_plural.' found')
           ,'not_found_in_trash' => __('No '.self::$object_name_plural.' found in trash')
           ,'parent_item_colon'  => ''
           ,'menu_name'          => self::$object_name
        );

        $args = array(
            'labels' => $labels
           ,'public' => true
           ,'publicly_queryable' => true
           ,'show_ui' => true
           ,'show_in_menu' => true
           ,'query_var' => true
           ,'rewrite' => array('slug' => 'loads')
           ,'capability_type' => 'post'
           ,'has_archive' => true
           ,'hierarchical' => false
           ,'menu_position' => null
           ,'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt')
        );

        register_post_type(self::$object_slug, $args);
    }

    // not sure we need this since it won't be front end
    public function saveObject() {}
    public function editObject() {}
    public function deleteObject() {}
}
Load::factory()->add_actions();
