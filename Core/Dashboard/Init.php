<?
Namespace Skytells\SFA;
if (!defined('ABSPATH')) { exit; }
Class Dashboard {

  public static function Init(){
          add_menu_page('Skytells Guard',
          'Skytells Guard', 'manage_options',
          SFA_SLUG,
          array('Skytells\SFA\Dashboard', 'Home'),
          'dashicons-smiley');
          global $SFA;
    add_action( 'wp_dashboard_setup', [$SFA, 'dashboardWidget'] );
    add_submenu_page(SFA_SLUG, __("Skytells Guard Reports"), __("Reports"), 'manage_options', 'sfa-reports', ['\Skytells\SFA\Dashboard', 'Reports']);
    add_action('admin_bar_menu', Array('Skytells\SFA\Dashboard', 'toolbar_link'), 999);
  }

  public static function Home(){
      global $SFA_SUMMARY;
      $SFA_SUMMARY = \Skytells\SFA\Foundation::getSecuritySummary();
      UI::render('Dashboard.dashboard', $SFA_SUMMARY);

  }

  public static function Reports() {
    global $SFA_SUMMARY;
    $GraphSummary = \Skytells\SFA\Reports::getGraphSummary();
    $SFA_SUMMARY = \Skytells\SFA\Foundation::getSecuritySummary();
    UI::render('Dashboard.Reports', ['securitySummary' => $SFA_SUMMARY, 'graphSummary' => $GraphSummary]);
  }

  public static function toolbar_link($wp_admin_bar) {
    if (get_bloginfo('version') >= 3.8) {
               // Dashicons is the official icon font of the WordPress admin as of 3.8
               $custom_styles = '#wp-admin-bar-skytells-guard-menu .ab-icon{transform:scaleX(-1)}#wp-admin-bar-skytells-guard-menu .ab-icon:before{top:3px;content:"\f332"}';
           } else {
               $custom_styles = '#wp-admin-bar-skytells-guard-menu .ab-icon{display:none}#wp-admin-bar-skytells-guard-menu .ab-label{margin:0}';
           }

    $args = array(
        'id' => 'skytells-guard-menu',
        'title' => '<span class="ab-icon"></span> Skytells Guard <style>' . $custom_styles . '</style>',
        'href' => admin_url('admin.php?page=skytells-guard'),
        'meta' => array(
            'class' => 'wpbeginner',
            'title' => 'Go to Skytells Security Center'
            )
    );
    $wp_admin_bar->add_node($args);
  }
  public static function InitModule($SubMenuTitle, $PageTitle, $Slug, $CallBack, $capability = 'manage_options') {

    add_submenu_page(SFA_SLUG, $PageTitle, $SubMenuTitle, $capability, $Slug, $CallBack);
  }

  public static function getCurrentScreen() {
    if (!is_admin()) {
			return false;
		}

    // Could be a miscellaneous page.
    if (array_key_exists('page', $_GET)) {
      if (preg_match('/^skyav\-/', $_GET['page']) || preg_match('/^skytells\-/', $_GET['page']) || preg_match('/^sfa\-/', $_GET['page'])) {
        return $_GET['page'];
      }
    }
  }
  public static function initScripts() {

    if (strpos(Dashboard::getCurrentScreen(), 'sfa-') !== false || strpos(Dashboard::getCurrentScreen(), 'skytells-') !== false || strpos(Dashboard::getCurrentScreen(), 'skyav-') !== false) {
      wp_register_style('skytells-1', getSFAURL().'/assets/style/css/bootstrap.min.css');

      wp_register_style('skytells-3', SKYTELLS_ASSETS.'/style/css/animate.min.css');
      wp_register_style('skytells-4', SKYTELLS_ASSETS.'/style/css/paper-dashboard.css');
      wp_register_style('skytells-5', 'https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css');
      wp_register_style('skytells-6', 'https://fonts.googleapis.com/css?family=Muli:400,300');
      wp_register_style('skytells-7', SKYTELLS_ASSETS.'/style/css/themify-icons.css');
      wp_register_style('skytells-av', SKYTELLS_ASSETS.'/css/av.css');

      // JQ
      //  wp_register_script('skytells-js-jquery', SKYTELLS_ASSETS.'/style/js/jquery-1.10.2.js');
      //  wp_enqueue_script( 'skytells-js-jquery' );

      wp_register_style('skytells-icons', SKYTELLS_ASSETS.'/css/materialIcons.css');
      wp_enqueue_style( 'skytells-icons' );




      wp_enqueue_style( 'skytells-1' );

      wp_enqueue_style( 'skytells-3' );
      wp_enqueue_style( 'skytells-4' );
      wp_enqueue_style( 'skytells-5' );
      wp_enqueue_style( 'skytells-6' );
      wp_enqueue_style( 'skytells-7' );
      wp_enqueue_style( 'skytells-av' );

      wp_register_style('skytells-wf', SKYTELLS_ASSETS.'/css/wf.css');
      wp_enqueue_style( 'skytells-wf' );

      wp_register_style('skytells-modals', SKYTELLS_ASSETS.'/css/modals.css');
      wp_enqueue_style( 'skytells-modals' );

      wp_register_style('skytells-swal', SKYTELLS_ASSETS.'/css/swal.css');
      wp_enqueue_style( 'skytells-swal' );

      wp_register_style('skytells-global', getSFAURL().'/assets/css/skytells.css');
      wp_enqueue_style( 'skytells-global' );

      wp_register_script('skytells-script-plugins', SKYTELLS_ASSETS.'/js/plugins.js');
      wp_enqueue_script( 'skytells-script-plugins' );


      wp_register_style('skytells-tippycss', getSFAURL().'/assets/css/tippy.css');
      wp_enqueue_style( 'skytells-tippycss' );



    }

  }
}
