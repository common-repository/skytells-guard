<?php
if (!defined('ABSPATH')) { exit; }
use Skytells\SFA\Dashboard;
class SkytellsMetaInfoProtection {

    public $options;

    public function __construct($loaded = false) {
      if ((bool)get_option('SFA_metatags') == true && $loaded == false) {
        $this->options = get_option('skytells_mp_options');
        $this->pkm_register_settings_and_fields();
      }
    }

    public function pkm_add_menu_page() {


      //  add_options_page('Skytells MetaInfo Protection', 'Skytells MetaInfo Protection', 'administrator', __FILE__, array('SkytellsMetaInfoProtection','pkm_display_options_page'));
    }

    public static function initMenu() {


      Dashboard::InitModule(__('MetaInfo Protection'), 'Metainfo Protection', 'sfa-metainfo-protection', array('SkytellsMetaInfoProtection','pkm_display_options_page'));
    }

    public static function pkm_display_options_page() {
        ?>
        <? oxygen_import('Layouts.Header', array("title" => 'Skytells Metainfo Protection', 'page' => 'metainfo')); ?>
        <div class="content">
            <div class="container-fluid">
        <style>
        .form-table th {

    padding: 0;
  }
  .form-table th, .form-wrap label {
    color: #585c61;
  }
  .form-table th {

        width: 40%;
    font-weight: normal;
  }
  .postbox .inside h2, .wrap [class$=icon32]+h2, .wrap h1, .wrap>h2:first-child {
    font-size: 17px;

    color: #464646;
}
p {
    font-size: 14px;
    line-height: 1.4em;
}
.form-table td {
    margin-bottom: 9px;
    padding: 15px 10px;
    line-height: 1;
    vertical-align: middle;
  }
    </style>
   <div class="wrap" id="sm_div">
  	<div id="poststuff" class="metabox-holder">

  		<div id="post-body-content" class="has-sidebar-content">
  			<div class="meta-box-sortabless">
  				<!-- Rebuild Area -->
  				<div id="sm_rebuild" class="postbox">
  					<h3 class="hndle">
  						<span>Metainfo Settings</span>
  					</h3>
  					<div class="inside">
              <?php @screen_icon();   if ((bool)get_option('SFA_metatags') === true) { ?>


                        <form method="post" action="options.php">
                          <?php
                        @settings_fields('skytells_mp_options');

                        @do_settings_sections(__FILE__);


                        ?>

                          <p class="submit">
                            <input name="submit" type="submit" class="button-primary" value="Save Changes" />
                          </p>
                        </form>
                      <? }else { ?>
                        The Meta Protection Module has been disabled from <a href="admin.php?page=sfa-settings">Skytells Settings</a>
                      <? } ?>
  										</div>
  									</div>
  								</div>
  							</div>
						</div>
          </div>
        </div>
      </div>
        <? oxygen_import('Layouts.Footer'); ?>
        <?php

    }


    /*************************************** URL AND PATH FUNCTIONS ***************************************/

  	/**
  	 * Returns the URL to the directory where the plugin file is located
  	 * @since 3.0b5
  	 * @return string The URL to the plugin directory
  	 */
  	public static function getPluginURL() {

  		$url = trailingslashit(plugins_url("", __FILE__));

  		return $url;
  	}

    public function pkm_register_settings_and_fields() {
        register_setting('skytells_mp_options', 'skytells_mp_options');

        add_settings_section('pkm_meta_generator_remover_section', '<h1>Metatags Settings</h1>', array($this, 'pkm_skytells_mp_callback'), __FILE__);

        add_settings_field('pkm_meta_generator_remover_enable_checkbox', '<p>Remove Meta Generator Tag</p>', array($this, 'pkm_meta_generator_remover_checkbox_setting'), __FILE__, 'pkm_meta_generator_remover_section');

        add_settings_section('pkm_skytells_mp_section', '<h1>Version Info Remover Settings</h1>', array($this, 'pkm_skytells_mp_callback'), __FILE__);
        add_settings_field('pkm_version_info_remover_style_checkbox', '<p>Remove Version from Stylesheet</p>', array($this, 'pkm_version_info_remover_style_checkbox_setting'), __FILE__, 'pkm_skytells_mp_section');
        add_settings_field('pkm_version_info_remover_script_checkbox', '<p>Remove Version from Script</p>', array($this, 'pkm_version_info_remover_script_checkbox_setting'), __FILE__, 'pkm_skytells_mp_section');
        add_settings_field('pkm_version_info_remover_script_exclude_css', '<p>Enter Stylesheet/Script file names to exclude from version removal<br>(comma separated list)</p>', array($this, 'pkm_version_info_remover_script_exclude_css'), __FILE__, 'pkm_skytells_mp_section');
    }

    public function pkm_skytells_mp_callback() {
        // no callback as of now
    }

    public function pkm_meta_generator_remover_checkbox_setting() {
        ?>
        <div class="checkbox">
        <input name="skytells_mp_options[pkm_meta_generator_remover_enable_checkbox]" type="checkbox" value="1"<?php checked( 1 == $this->options['pkm_meta_generator_remover_enable_checkbox'] ); ?> />
        </div>
        <?php
    }

    public function pkm_version_info_remover_style_checkbox_setting() {
        ?>
        <div class="checkbox">
        <input name="skytells_mp_options[pkm_version_info_remover_style_checkbox]" type="checkbox" value="1" <?php checked( 1 == $this->options['pkm_version_info_remover_style_checkbox'] ); ?> />
        </div>
        <?php
    }

    public function pkm_version_info_remover_script_checkbox_setting() {
        ?>
        <div class="checkbox">
        <input name="skytells_mp_options[pkm_version_info_remover_script_checkbox]" type="checkbox" value="1"<?php checked( 1 == $this->options['pkm_version_info_remover_script_checkbox'] ); ?> />
        </div>
        <?php
    }

    public function pkm_version_info_remover_script_exclude_css() {
        ?>
        <textarea placeholder="Enter comma separated list of file names (Stylesheet/Script files) to exclude them from version removal process. Version info will be kept for these files." name="skytells_mp_options[pkm_version_info_remover_script_exclude_css]" rows="7" cols="60" style="resize:none;"><?php if (isset($this->options['pkm_version_info_remover_script_exclude_css'])) { echo $this->options['pkm_version_info_remover_script_exclude_css']; } ?></textarea>
        <?php
    }
}

$options = get_option('skytells_mp_options');
if( isset($options['pkm_version_info_remover_script_exclude_css']) ) {
    $exclude_file_list = $options['pkm_version_info_remover_script_exclude_css'];
} else {
    $exclude_file_list = '';
}
$exclude_files_arr = array_map('trim', explode(',', $exclude_file_list));

/**
 * Hook into the generator.
 */
 if ((bool)get_option('SFA_metatags') == true) {
  if( isset($options['pkm_meta_generator_remover_enable_checkbox']) && ($options['pkm_meta_generator_remover_enable_checkbox'] == 1) ) {
      add_filter( 'the_generator', '__return_null' );
  }
}

/**
 *  remove wp version param from any enqueued scripts (using wp_enqueue_script()) or styles (using wp_enqueue_style()). But first check the list of user defined excluded CSS/JS files... Those files will be skipped and version information will be kept.
 */
function pkm_remove_appended_version_script_style( $target_url ) {
    $filename_arr = explode('?', basename($target_url));
    $filename = $filename_arr[0];
    global $exclude_files_arr, $exclude_file_list;
    // first check the list of user defined excluded CSS/JS files
    if (!in_array(trim($filename), $exclude_files_arr)) {
        /* check if "ver=" argument exists in the url or not */
        if(strpos( $target_url, 'ver=' )) {
            $target_url = remove_query_arg( 'ver', $target_url );
        }
    }
    return $target_url;
}

/**
 * Priority set to 20000. Higher numbers correspond with later execution.
 * Hook into the style loader and remove the version information.
 */
if( isset($options['pkm_version_info_remover_style_checkbox']) && ($options['pkm_version_info_remover_style_checkbox'] == 1) ) {
add_filter('style_loader_src', 'pkm_remove_appended_version_script_style', 20000);
}

/**
 * Hook into the script loader and remove the version information.
 */
if( isset($options['pkm_version_info_remover_script_checkbox']) && ($options['pkm_version_info_remover_script_checkbox'] == 1) ) {
add_filter('script_loader_src', 'pkm_remove_appended_version_script_style', 20000);
}

add_action('admin_menu', 'pkm_meta_generator_add_options_page_function');

function pkm_meta_generator_add_options_page_function() {
    $object = new SkytellsMetaInfoProtection();

    $object->pkm_add_menu_page();
}

add_action('admin_init', 'pkm_meta_generator_remover_initiate_class');

function pkm_meta_generator_remover_initiate_class() {
    new SkytellsMetaInfoProtection();
}

function skytells_mp_defaults() {
    $current_options = get_option('skytells_mp_options');

    $defaults = array(
        'pkm_meta_generator_remover_enable_checkbox'            => 1,
        'pkm_version_info_remover_style_checkbox'               => 1,
        'pkm_version_info_remover_script_checkbox'              => 1,
        'pkm_version_info_remover_script_exclude_css'           => ( isset($current_options['pkm_version_info_remover_script_exclude_css']) ? $current_options['pkm_version_info_remover_script_exclude_css'] : '' )
    );

    if( is_admin() ) {
        update_option( 'skytells_mp_options', $defaults );
    }
}

register_activation_hook( __FILE__, 'skytells_mp_defaults' );

function skytells_mp_set_plugin_meta($links, $file) {

    $plugin = plugin_basename(__FILE__);

    // create link
    if ($file == $plugin) {
        return array_merge(
            $links,
            array( sprintf( '<a href="options-general.php?page=%s">%s</a>', $plugin, __('Settings') ) )
        );
    }

    return $links;
}
if ((bool)get_option('SFA_metatags') == true) {
add_filter( 'plugin_row_meta', 'skytells_mp_set_plugin_meta', 10, 2 );
}
?>
