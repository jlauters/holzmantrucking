<?php

/* Extended_Object
 * Abstract Class which gets extended by individual post_type classes
 * Contains Generic functionality, WP Post Type and Taxonomy cruft
 */

abstract class Extended_Object {

    static $object_slug;
    static $object_name;
    static $object_name_plural;
    static $taxonomies;

    /* Gets defined by Child Class */
    abstract protected function add_actions();
    abstract protected function request_handler();
    abstract protected function saveObject();
    abstract protected function editObject();
    abstract protected function deleteObject();

    public function add_custom_post_type() {

        $labels = array(
            'name'               => __(static::$object_name_plural)
           ,'singular_name'      => __(static::$object_name)
           ,'add_new'            => __('Add New')
           ,'add_new_item'       => __('Add New '.static::$object_name)
           ,'edit_item'          => __('Edit '.static::$object_name)
           ,'new_item'           => __('New '.static::$object_name)
           ,'all_items'          => __('All '.static::$object_name_plural)
           ,'view_items'         => __('View '.static::$object_name_plural)
           ,'search_items'       => __('Search '.static::$object_name_plural)
           ,'not_found'          => __('No '.static::$object_name_plural.' found')
           ,'not_found_in_trash' => __('No '.static::$object_name_plural.' found in trash')
           ,'parent_item_colon'  => ''
           ,'menu name'          => static::$object_name
        );

        $args = array(
            'labels'             => $labels
           ,'public'             => true
           ,'publicly_queryable' => true
           ,'show_ui'            => true
           ,'show_in_menu'       => true
           ,'query_var'          => true
           ,'rewrite'            => array('slug' => static::$object_slug)
           ,'capability_type'    => 'post'
           ,'has_archive'        => true
           ,'hierarchical'       => false
           ,'menu_position'      => null
           ,'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt')
        );

        register_post_type(static::$object_slug, $args);
    }

    public function add_post_type_taxonomies() {

        foreach(static::$taxonomies as $tax) {

            $labels = array(
                'name'                       => __($tax['name'])
               ,'singular_name'              => __($tax['name'])
               ,'search_items'               => __('Search '.$tax['name'].' Terms')
               ,'popular_items'              => __('Popular '.$tax['name'].' Terms')
               ,'all_items'                  => __('All '.$tax['name'].' Terms')
               ,'parent_item'                => __($tax['parent'])
               ,'parent_item_colon'          => '::'
               ,'edit_item'                  => __('Edit '.$tax['name'])
               ,'update_item'                => __('Update '.$tax['name'])
               ,'add_new_item'               => __('Add New '.$tax['name'])
               ,'new_item_name'              => __('New '.$tax['name'])
               ,'separate_items_with_commas' => __('Separate '.$tax['name'].' with commas')
               ,'add_or_remove_items'        => __('Add or Remove '.$tax['name'])
               ,'choose_from_most_used'      => __('Choose from the most used '.$tax['name'])
               ,'menu_name'                  => __($tax['name']) 
            );

            $args = array(
                'hierarchical'          => true
               ,'labels'                => $labels
               ,'show_ui'               => true
               ,'show_admin_column'     => true
               ,'update_count_callback' => '_update_post_term_count'
               ,'query_var'             => true
               ,'rewrite'               => array('slug' => 'locations')
            );

            register_taxonomy($tax['slug'], $tax['post_type'], $args);
            $result = register_taxonomy_for_object_type($tax['slug'], $tax['post_type']);

            if($result) {
                /* Clean up hierarchical taxonomy detection */
                foreach($tax['terms'] as $name => $term) {

                    if(is_array($term)) {

                        $parent = 0;
                        $result = wp_insert_term($name, $tax['slug']);
                        if(!is_a($result, 'WP_Error')) {
                            $parent = $result['term_id'];
                        } 

                        foreach($term as $child_term) {
 
                            if(!$parent) {
                                $parent_term = term_exists($name, $tax['slug']);
                                $parent = $parent_term['term_id'];
                            }

                            wp_insert_term($child_term, $tax['slug'], array('parent' => $parent));
                        }
                    } else {
                        wp_insert_term($term, $tax['slug']);
                    }
                }
            } 
        }
    }
}

?>
