<?php
Namespace Skytells\SFA;
Class RestAPI {
  public static function wake(){
    if ((bool)get_option('SFA_disable_JSONAPI_USERS') == true) {
      // Filters for WP-API version 1.x
       add_filter( 'json_enabled', '__return_false' );
       add_filter( 'json_jsonp_enabled', '__return_false' );

       // Filters for WP-API version 2.x
       add_filter( 'rest_enabled', '__return_false' );
       add_filter( 'rest_jsonp_enabled', '__return_false' );
       remove_action('wp_head', 'rest_output_link_wp_head', 10);
       add_filter( 'rest_api_init', function(){
       if ( is_user_logged_in() ) {
               wp_die('<b>Secured by Skytells Guard</b><br>This API is currently disabled for Authenticated Users, Which means that you will not be able to perform any request to this endpoint','Secured by Skytells Guard',403);
           }
       }, 99 );
    }

    if ((bool)get_option('SFA_disable_JSONAPI', true) == true) {
      // Filters for WP-API version 1.x
       add_filter( 'json_enabled', '__return_false' );
       add_filter( 'json_jsonp_enabled', '__return_false' );

       // Filters for WP-API version 2.x
       add_filter( 'rest_enabled', '__return_false' );
       add_filter( 'rest_jsonp_enabled', '__return_false' );
       remove_action('wp_head', 'rest_output_link_wp_head', 10);
       add_filter( 'rest_api_init', function(){
         if ( !is_user_logged_in() ) {
               wp_die('<b>Secured by Skytells Guard</b><br>This API is currently disabled for Public, Which means that you cannot perform requests on this node.','Secured by Skytells Guard',403);
             }
       }, 99 );
    }
  }
}
