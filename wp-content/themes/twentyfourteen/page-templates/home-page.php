<?php
/**
 * Template Name: Home Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<div id="main-content" class="main-content">

	<div id="primary" class="content-area">
		<section id="content">
 
            <div class="content-box">
                <h3>Loads for <?php echo date('m/d/Y'); ?></h3>
            <ul class="list-unstyled" style="padding: 2% 3%;">
			<?php

               $args = array(
                   'post_type' => 'load'
                  ,'post_status' => 'publish'
                  ,'posts_per_page' => -1
                  ,'orderby' => 'meta_value'
                  ,'meta_key' => 'start_time'
                  ,'order' => 'ASC'
               );

               $query = new WP_Query($args);
               if($query) {
                   foreach($query->posts as $post) {

                       $today       = date('Y-m-d');
                       $start_date  = date('Y-m-d', strtotime(get_post_meta($post->ID, 'start_time', true)));

                       if($today === $start_date) {
                           $start_time  = date('h:i', strtotime(get_post_meta($post->ID, 'start_time', true)));
                           $driver      = get_post_meta($post->ID, 'driver_name', true);
                           $destination = get_post_meta($post->ID, 'destination', true);
                           $trailer_num = get_post_meta($post->ID, 'trailer_num', true);
                           $edit_link   = get_edit_post_link($post->ID);
                           $rate        = get_post_meta($post->ID, 'rate', true);

                           $load_html = <<<EOHTML
<li style="padding: 10px 0; width: 100%">
    <span>{$start_time} {$driver} <strong>{$post->post_title}</strong> {$destination} Trailer / Van #{$trailer_num} {$rate} 
    <a href="{$edit_link}"><button type="button"  class="btn btn-primary pull-right">Edit</button></a>
</li>
EOHTML;

                           echo $load_html;

                       } 
                   }
               }

               wp_reset_query();

			?>
            </ul>
            </div>
		</section><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_footer();
