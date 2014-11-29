<?php

class LoadMeta {

    private function __construct() {}

    public static function factory() { return new LoadMeta(); }

    function add_actions() {
        add_action('add_meta_boxes', array($this, 'get_load_meta'));
        add_action('save_post', array($this, 'save_load_meta'), 10, 2);
    }

    public function get_load_meta() {
        add_meta_box(
            'load_meta'
           ,__('Trucking Load Meta', 'holzman')
           ,array($this, 'render_load_meta_box')
           ,'load'
           ,'advanced'
           ,'high'
        );
    }

    public function render_load_meta_box($object, $box) {
        wp_nonce_field(basename(__FILE__), 'load_meta_nonce');

        $start_time  = esc_attr(get_post_meta($object->ID, 'start_time', true));
        $destination = esc_attr(get_post_meta($object->ID, 'destination', true));
        $driver_name = esc_attr(get_post_meta($object->ID, 'driver_name', true));
        $trailer_num = esc_attr(get_post_meta($object->ID, 'trailer_num', true));
        $rate        = esc_attr(get_post_meta($object->ID, 'rate', true));
  

        echo <<<EOHTML
<style type="text/css">
    .field { padding: 1%; }
    #preview { max-width: 120px; height: auto; }
</style>


<div style="clear: both; margin: 2% 0; padding-top: 1%;">
    <h3>Load Details</h3>

    <div class="field">
        <label for="start_time">Start Time</label>
        <br/>
        <input type="datetime" id="start_time" name="start_time" value="{$start_time}"/>
    </div>

    

    <div class="field">
        <label for="destination">Destination</label>
        <br/>
        <input type="text" id="destination" name="destination" value="{$destination}"/>
    </div>

    <div class="field">
        <label for="driver_name">Driver Name</label>
        <br/>
        <input type="text" id="driver_name" name="driver_name" value="{$driver_name}"/>
    </div>

    <div class="field">
        <label for="trailer_num">Trailer / Van #</label>
        <br/>
        <input type="text" id="trailer_num" name="trailer_num" value="{$trailer_num}"/>
    </div>

    <div class="field">
        <label for="rate">Rate</label>
        <br/>
        <input type="text" id="rate" name="rate" value="{$rate}"/>
    </div>

</div>

EOHTML;

    }

    public function save_load_meta($post_id, $post) {

        // verify nonce
        $nonce = $_POST['load_meta_nonce'];
        if(!isset($nonce) || !wp_verify_nonce($nonce, basename(__FILE__))) {
            return $post_id;
        }

        // verify user permissions on post type
        $post_type = get_post_type_object($post->post_type);
        if(!current_user_can($post_type->cap->edit_post, $post_id)) {
            return $post_id;
        }

        $meta_items = array(
            array('type' => 'datetime', 'name' => 'start_time')
           ,array('type' => 'text', 'name' => 'destination')
           ,array('type' => 'text', 'name' => 'driver_name')
           ,array('type' => 'text', 'name' => 'trailer_num')
           ,array('type' => 'text', 'name' => 'rate')
        );

        foreach($meta_items as $meta_item) {
   
            $new_value = NULL;

            if('text' === $meta_item['type']) {
                $new_value = (isset($_POST[$meta_item['name']]) ? sanitize_text_field($_POST[$meta_item['name']]) : '');
            }

            if('datetime' === $meta_item['type']) {
                $new_value = (isset($_POST[$meta_item['name']]) ? date('Y-m-d h:i:s', strtotime($_POST[$meta_item['name']])) : '');
            }

            if('textarea' === $meta_item['type']) {
                $new_value = (isset($_POST[$meta_item['name']]) ? esc_textarea($_POST[$meta_item['name']]) : '');
            }

            if('checkboxes' === $meta_item['type']) {
                $new_value = serialize($_POST[$meta_item['name']]);
            }

            $value = get_post_meta($post_id, $meta_item['name'], true);
            if($new_value && '' == $value) {
                add_post_meta($post_id, $meta_item['name'], $new_value, true);
            } else if($new_value && $new_value != $value) {
                update_post_meta($post_id, $meta_item['name'], $new_value);
            } else if('' == $new_value && $value) {
                delete_post_meta($post_id, $meta_item['name'], $value);
            }
        }
    }
}
LoadMeta::factory()->add_actions();
