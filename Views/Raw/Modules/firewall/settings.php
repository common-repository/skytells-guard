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
<? layout_import('header', array("title" => 'Skytells Firewall Settings', 'page' => 'firewall')); ?>
      <div class="content">
<div class="wrap" id="sm_div">
 <div id="poststuff" class="metabox-holder">
  <div id="post-body-content" class="has-sidebar-content">
    <div class="meta-box-sortabless">
      <!-- Rebuild Area -->
      <div id="sm_rebuild" class="postbox">
        <h3 class="hndle">
          <span>Skytells AI-Guard</span>
        </h3>
        <div class="inside">
          <div class="wrap">
            <div class="row">
              <!--  style="margin-bottom: -8px; padding-right: 5px;" -->
              <div class="col-xs-1" style="width:5%;">
              <img src="<?= getSFAURL(); ?>/assets/images/icon.svg"  style="" height="47px">
            </div>
            <div class="col-xs-11" style="width:95%;">
                <h1 style="color: #3a88c9; ">Skytells Firewall</h1>
              </div>

            </div>
            <!-- Image and text -->

                <div class="sfa-desc">
                <p>The Firewall Protectes your WordPress against SQL Injection, DDoS attacks ..etc.
                  <br>We're strongly recommends to enable this advanced firewall.

                      </p>
                    </div>
                  </div>
          </div>

        </div>


      </div>





  <? sfa_alert('ProFeature', ['feature' => 'Firewall']); ?>



      <div id="sm_rebuild" class="postbox">

        <h3 class="hndle">
          <span>Skytells Firewall Settings</span>
        </h3>
        <div class="inside">
          <br>
          <form method="post" action="options.php">

              <?php settings_fields('sfa-firewall'); ?>
              <div class="col-md-12">
                <div class="checkbox checkbox-info">
                <input class="form-check-input" type="checkbox" id="skfw_status" name="skfw_status" value="true" <?php echo ($this->__options['status']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="skfw_status"><?php _e('Firewall Status (Tick to Enable Firewall)', 'sfa-firewall'); ?></label>
              </div>
            </div>


            <div class="col-md-12">
              <div class="checkbox checkbox-info">
              <input class="form-check-input" type="checkbox" id="skfw_ddos_status" name="skfw_ddos_status" value="true" <?php echo ($this->__options['ddos_status']) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="skfw_ddos_status"><?php _e('DDoS Attacks Protection (Tick to Enable)', 'sfa-firewall'); ?></label>
            </div>
          </div>



            <div class="col-md-12">
              <br>
              <label for="skfw_allowed-chars"><?php _e('Allowed Chars', 'sfa-firewall'); ?></label>
              <input  type="text" name="skfw_allowedchars" value="<?php echo $this->__options['allowedchars']; ?>"
               id="skfw_allowedchars" class="form-control" aria-describedby="skfw_allowed-charsH">
              <small id="skfw_allowed-charsH" class="form-text text-muted">
                <?php _e('Write the RegEx Pattern for the allowed chars, Please do not change it until you learn how to handle RegEx', 'sfa-firewall'); ?>
              </small>
            </div>

            <div class="col-md-12">
              <br>
              <label for="skfw_whitelisted"><?php _e('Whitelisted URI(s)', 'sfa-firewall'); ?></label>
              <input  type="text" name="skfw_whitelisted" value="<?php echo $this->__options['whitelisted']; ?>"
               id="skfw_whitelisted" class="form-control" aria-describedby="skfw_whitelistedH">
              <small id="skfw_whitelistedH" class="form-text text-muted">
                <?php _e('Write a URLs to skip from Firewall Checks, Split URLs by (,) Or leave it empty to protect all URLs', 'sfa-firewall'); ?>
              </small>
            </div>


            <div class="col-md-12">
              <br>
              <label for="skfw_whitelisted"><?php _e('Blocked Message (HTML)', 'sfa-blockedmessage'); ?></label>
              <textarea id="skfw_blockedmessage" class="form-control" aria-describedby="skfw_blockedmessageH" type="text" rows="2" name="skfw_blockedmessage"><?php echo $this->__options['blockedmessage']; ?></textarea>

              <small id="skfw_blockedmessageH" class="form-text text-muted">
                <?php _e('This message will be displayed when someone blocked from your website', 'sfa-firewall'); ?>
              </small>
            </div>
            <div class="col-md-12">

              <br>
                <? if (\Skytells\SFA::CL()) : ?>
              <?php submit_button(__('Save', 'sfa-firewall'), 'primary', 'submit', false); ?>&nbsp;
              <a href="javascript:ResetOptions()" class="button"><?php _e('Reset', 'sfa-firewall'); ?></a>
            <? else: ?>
            <p class="form-pro-req">You need to have a Pro License to Enable These settings.</p>
            <? endif; ?>
          </div>

          <div class="postbox-footer" style="">
            &nbsp;
          </div>


        </form>



       </div>

        </div>


      </div>
    </div>
</div>



<form id="reset_form" method="post" action="">
    <input type="hidden" name="reset" value="true" />
</form>



</div>

<? layout_import('footer'); ?>
