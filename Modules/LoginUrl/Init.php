<?php

add_action('init', 'clu_init_urls');
add_action('init', 'clu_init_redirect');
add_action('generate_rewrite_rules', 'clu_generate_rewrite_rules');

include_once dirname(__FILE__) . '/functions.php';

if(is_admin()) {
    add_action('admin_init', 'clu_admin_init');
    register_deactivation_hook( __FILE__, 'clu_deactivate' );

    include_once dirname(__FILE__) . '/functions-admin.php';
}
