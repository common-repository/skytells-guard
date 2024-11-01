<?php
if (!is_admin()) {
    die();
}
?>
<style type="text/css">
    .sfa-brute-force .status-yes {
        color:#27ae60;
    }
    .sfa-brute-force .status-no {
        color:#cd3d2e;
    }
    .sfa-brute-force .postbox-footer {
        padding:10px;
        clear:both;
        border-top:1px solid #ddd;
        background:#fff;
    }
    .sfa-brute-force input[type="number"] {
        width:60px;
    }
    .sfa-brute-force tr.even {
        background-color:#f5f5f5;
    }
</style>
<script type="text/javascript">
    function ResetOptions() {
        if (confirm("<?php _e('Are you sure you want to reset all options?', 'sfa-brute-force'); ?>")) {
            document.forms["reset_form"].submit();
        }
    }

</script>
<? oxygen_import('Layouts.Header', array("title" => 'Skytells reCaptcha Settings', 'page' => 'recaptcha')); ?>
      <div class="content">
        <div class="container-fluid">

        <div class="wrap" id="sm_div">
          <? if ((bool)get_option('SFA_recaptcha_module') !== true) : ?>
          <div class="row">
            <div class="col-xs-12">
              <div class="alert alert-warning">
                <button type="button" aria-hidden="true" class="close">×</button>
                <strong><b>THIS MODULE IS CURRENTLY DISABLED!</b></strong>
                  <span><b> Warning - </b> This module is currently disabled from your settings page!</span>
                  <span>You can Enable or Disable this module from Skytells Guard Settings!</span>

                </div>
            </div>
          </div>
          <? endif; ?>

         <div id="poststuff" class="metabox-holder">
          <div id="post-body-content" class="has-sidebar-content">
            <div class="meta-box-sortabless">
              <!-- Rebuild Area -->
              <div id="sm_rebuild" class="postbox">
                <h3 class="hndle">
                  <span>Skytells reCaptcha Module Settings</span>
                </h3>
                <div class="inside">

<form method="post" action="options.php">
<?php
echo settings_fields( 'sfa_recaptcha' );
?>
<p><?php echo sprintf(__('<a href="%s" target="_blank">Click here</a> to create or view keys for Google NoCaptcha.','sfa_recaptcha'),'https://www.google.com/recaptcha/admin#list'); ?></p>
<table class="form-table">
    <tr valign="top">
            <th scope="row"><label for="id_sfa_recaptcha_key"><?php _e('Site Key','sfa_recaptcha'); ?>: </span>
            </label></th>
        <td><input type="text" id="id_sfa_recaptcha_key" name="sfa_recaptcha_key" value="<?php echo get_option('sfa_recaptcha_key'); ?>" size="40" /></td>
    </tr>
    <tr valign="top">
            <th scope="row"><label for="id_sfa_recaptcha_secret"><?php _e('Secret Key','sfa_recaptcha'); ?>: </span>
            </label></th>
        <td><input type="text" id="id_sfa_recaptcha_secret" name="sfa_recaptcha_secret" value="<?php echo get_option('sfa_recaptcha_secret'); ?>" size="40" /></td>
    </tr>
    </table>
    <p>
    <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes','sfa_recaptcha'); ?>">
    <button name="reset" id="reset" class="button">
        <?php _e('Delete Keys and Disable','sfa_recaptcha'); ?>
    </button>
    </p>
</form>
<?php if(strlen(get_option('sfa_recaptcha_key')) > 0 && strlen(get_option('sfa_recaptcha_secret')) > 0): ?>
    <h3><?php _e('Example','sfa_recaptcha'); ?></h3>
    <?php wp_enqueue_script('sfa_recaptcha_google_api'); ?>
    <?php SFA_reCaptcha::nocaptcha_form(); ?>
    <h3><?php _e('Next Steps','sfa_recaptcha'); ?></h3>
    <ol>
        <li><?php _e('If you see an error message above, check your keys before proceeding.','sfa_recaptcha'); ?></li>
        <li><?php _e('If the reCAPTCHA displays correctly above, proceed as follows:','sfa_recaptcha'); ?></li>
        <ol>
            <li><?php _e('Open a completely different browser than this one','sfa_recaptcha'); ?></li>
            <li><?php _e('If you are logged in on that new browser, log out','sfa_recaptcha'); ?></li>
            <li><?php _e('Attempt to log in to your site admin from that new browser','sfa_recaptcha'); ?></li>
        </ol>
        <li><?php _e('Do <em>not</em> close this window or log out from this browser until you are confident that reCAPTCHA is working and you will be able to log in again. <br /><strong>You have been warned</strong>.','sfa_recaptcha'); ?></li>
        <li><?php echo sprintf(__('If you have any problems logging in, click "%s" above and/or deactivate the plugin.','sfa_recaptcha'), __('Delete Keys and Disable','sfa_recaptcha')); ?></li>
    </ol>
<?php endif; ?>
</div>
<script>
(function($) {
    $('#reset').on('click', function(e) {
        e.preventDefault();
        $('#id_sfa_recaptcha_key').val('');
        $('#id_sfa_recaptcha_secret').val('');
        $('#submit').trigger('click');
    });
})(jQuery);
</script>
<style>
    #submit + #reset {
        margin-left: 1em;
    }
</style>

</div>
</div></div></div></div></div>
<? oxygen_import('Layouts.Footer'); ?>
