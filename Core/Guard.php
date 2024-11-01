<?php
Namespace Skytells\SFA;
Use Skytells\SFA\Core, Skytells\SFA\Foundation,
    Skytells\Controllers\HTTP, Skytells\SFA\Option;
Class Guard extends Core {
  public $COptions = [];
  public function __construct($args = []) {
    $this->setCoreOptions();
    parent::__construct($this->COptions);
    $this->onStartEvents();
  }

  public function onStartEvents() {
    if (Option::get('SFA_RSS_DISABLE', 'bool') === true) {
      $this->SecureRSSFeed();
    }

    if (Option::get('SFA_Maintenance', 'bool') === true) {
      add_action('wp_head', [$this, 'ShowMaintenance']);
    }

    if (Option::get('SFA_Disable_X_PingBack', 'bool') === true) {
      add_filter('wp_headers', [$this, 'remove_x_pingback']);
    }
  }

  public function ShowMaintenance() {
    wp_die( __(get_option('SFA_MaintenanceMessage', 'Our website is in maintenance right now!') ) );
  }
  public function setCoreOptions() {
    $this->COptions = ['RSS_DISABLE' => false, 'Disable_X_PingBack' => false];
  }

  public function SecureRSSFeed() {
    add_action('do_feed', [$this, 'RSSAction'], 1);
    add_action('do_feed_rdf', [$this, 'RSSAction'], 1);
    add_action('do_feed_rss', [$this, 'RSSAction'], 1);
    add_action('do_feed_rss2', [$this, 'RSSAction'], 1);
    add_action('do_feed_atom', [$this, 'RSSAction'], 1);
    add_action('do_feed_rss2_comments', [$this, 'RSSAction'], 1);
    add_action('do_feed_atom_comments', [$this, 'RSSAction'], 1);
    remove_action( 'wp_head', [$this, 'RSSAction'], 2 );
    remove_action( 'wp_head', [$this, 'RSSAction'], 3 );

  }
  public function RSSAction() {
    wp_die( __( 'No feed available, Please visit the <a href="'. esc_url( home_url( '/' ) ) .'">Home Page</a>!' ) );
  }

  public function remove_x_pingback($headers) {
    unset($headers['X-Pingback']);
    return $headers;
  }



}
