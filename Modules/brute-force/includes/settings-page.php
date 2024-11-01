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

    function WhitelistCurrentIP() {
        document.forms["whitelist_current_ip_form"].submit();
    }
</script>
<? layout_import('header', array("title" => 'Skytells Brute Force Settings', 'page' => 'brute-force')); ?>
        <div class="content">
            <div class="container-fluid">
<div class="wrap">
  <? sfa_alert('ProFeature', ['feature' => 'Brute Force Protection']); ?>

  <div class="wrap sfa-brute-force">


      <div class="metabox-holder">
          <div class="postbox">
              <?php $status = $this->__htaccess->checkRequirements(); ?>
              <h3>
                  <?php _e('Status', 'sfa-brute-force'); ?>
                  <?php if (in_array(false, $status)): ?>
                      <span class="dashicons dashicons-no status-no"></span><small class="status-no"><O class="status-no" style="font-size: 14px;"><?php _e('You are not protected!', 'sfa-brute-force'); ?></O></small>
                  <?php elseif ((!\Skytells\SFA::CL())): ?>
                    <span class="dashicons dashicons-no status-no"></span><small class="status-no"><O class="status-no" style="font-size: 14px;"><?php _e('You are not protected!', 'sfa-brute-force'); ?></O></small>

                <?php else: ?>
                    <span class="dashicons dashicons-yes status-yes"></span><small class="status-yes"><?php _e('You are protected!', 'sfa-brute-force'); ?></small>
                <?php endif; ?>
              </h3>
              <div class="inside">
                  <?php if ($status['found']): ?>
                      <span class="dashicons dashicons-yes status-yes"></span> <strong><?php _e('.htaccess file found', 'sfa-brute-force'); ?></strong>
                  <?php else: ?>
                      <span class="dashicons dashicons-no status-no"></span> <strong><?php _e('.htaccess file not found', 'sfa-brute-force'); ?></strong>
                  <?php endif; ?>
                  <br />
                  <?php if ($status['readable']): ?>
                      <span class="dashicons dashicons-yes status-yes"></span> <strong><?php _e('.htaccess file readable', 'sfa-brute-force'); ?></strong>
                  <?php else: ?>
                      <span class="dashicons dashicons-no status-no"></span> <strong><?php _e('.htaccess file not readable', 'sfa-brute-force'); ?></strong>
                  <?php endif; ?>
                  <br />
                  <?php if ($status['writeable']): ?>
                      <span class="dashicons dashicons-yes status-yes"></span> <strong><?php _e('.htaccess file writeable', 'sfa-brute-force'); ?></strong>
                  <?php else: ?>
                      <span class="dashicons dashicons-no status-no"></span> <strong><?php _e('.htaccess file not writeable', 'sfa-brute-force'); ?></strong>
                  <?php endif; ?>

                  <br />
                <?php if (\Skytells\SFA::CL()): ?>
                      <span class="dashicons dashicons-yes status-yes"></span> <strong><?php _e('Brute-Force Enabled', 'sfa-brute-force'); ?></strong>
                  <?php else: ?>
                      <span class="dashicons dashicons-no status-no"></span> <strong><?php _e('Brute-Force Disabled - Pro License needed', 'sfa-brute-force'); ?></strong>
                  <?php endif; ?>
              </div>
          </div>

          <div id="sm_smres" class="postbox">
            <h3 class="hndle">
              <span><?php _e('Brute Force Options', 'sfa-brute-force'); ?></span>
            </h3>
            <div class="inside">
              <form method="post" action="options.php">
                  <?php settings_fields('sfa-brute-force'); ?>
                  <div class="inside">
                    <div class="form-row">



                      <div class="form-group col-md-12">
                        <label for="bflp_allowed_attempts"><?php _e('Allowed login attempts before blocking IP', 'sfa-brute-force'); ?></label>
                        <input type="number" min="1" max="100" name="bflp_allowed_attempts" value="<?php echo $this->__options['allowed_attempts']; ?>" id="bflp_allowed_attempts" class="form-control" aria-describedby="bflp_allowed_attemptsH">
                        <small id="bflp_allowed_attemptsH" class="form-text text-muted">
                          Enter the maximum login attempts before blocking the IP address, Recommended to be 10.
                        </small>
                      </div>



                      <div class="form-group col-md-12">
                        <label for="bflp_reset_time"><?php _e('Reset Period', 'sfa-brute-force'); ?></label>
                        <input  type="number" min="1" name="bflp_reset_time" value="<?php echo $this->__options['reset_time']; ?>"
                         id="bflp_reset_time" class="form-control" aria-describedby="bflp_reset_timeH">
                        <small id="bflp_reset_timeH" class="form-text text-muted">
                          Minutes before resetting login attempts count, Recommended to be 60.
                        </small>
                      </div>


                      <div class="form-group col-md-12">
                        <label for="bflp_reset_time"><?php _e('Login Attempts Delay Period', 'sfa-brute-force'); ?></label>
                        <input  type="number" min="1" max="10" name="bflp_login_failed_delay" value="<?php echo $this->__options['login_failed_delay']; ?>"
                         id="bflp_login_failed_delay" class="form-control" aria-describedby="bflp_login_failed_delayH">
                        <small id="bflp_login_failed_delayH" class="form-text text-muted">
                          <?php _e('Delay in seconds when a login attempt has failed (to slow down brute force attack), Recommended to be 1', 'sfa-brute-force'); ?>
                        </small>
                      </div>



                      <div class="col-md-12">
                        <div class="checkbox">
                        <input type="checkbox" id="bflp_inform_user" name="bflp_inform_user" value="true" <?php echo ($this->__options['inform_user']) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="bflp_inform_user"><?php _e('Inform user about remaining login attempts on login page', 'sfa-brute-force'); ?></label>
                      </div>
                    </div>


                    <div class="col-md-12">
                      <div class="checkbox">
                      <input type="checkbox" type="checkbox" id="bflp_send_email"  name="bflp_send_email" value="true" <?php echo ($this->__options['send_email']) ? 'checked' : ''; ?>>
                      <label class="form-check-label" for="bflp_send_email"><?php _e('Send email to administrator when an IP has been blocked', 'sfa-brute-force'); ?></label>
                    </div>
                  </div>


                  <div class="form-group col-md-6">
                    <label for="bflp_403_message"><?php _e('Block Message', 'sfa-brute-force'); ?></label>
                    <input  type="text" size="70" name="bflp_403_message" value="<?php echo $this->__options['403_message']; ?>"
                     id="bflp_login_failed_delay" class="form-control" aria-describedby="bflp_403_messageH">
                    <small id="bflp_403_messageH" class="form-text text-muted">
                      <?php _e('Message to show to blocked users (leave empty for default message)', 'sfa-brute-force'); ?>
                    </small>
                  </div>


                  <div class="form-group col-md-6">
                    <label for="bflp_403_message"><?php _e('Htaccess Path', 'sfa-brute-force'); ?></label>
                    <input  type="text" size="70" name="bflp_htaccess_dir" value="<?php echo $this->__options['htaccess_dir']; ?>"
                     id="bflp_htaccess_dir" class="form-control" aria-describedby="bflp_htaccess_dirH">
                    <small id="bflp_htaccess_dirH" class="form-text text-muted">
                      <?php _e('The path of .htaccess file, Please make sure that the file exists in this path', 'sfa-brute-force'); ?>
                    </small>
                  </div>



                  </div>
                  <div class="postbox-footer" style="">
                      <?php submit_button(__('Save', 'sfa-brute-force'), 'primary', 'submit', false); ?>&nbsp;
                      <a href="javascript:ResetOptions()" class="button"><?php _e('Reset', 'sfa-brute-force'); ?></a>
                  </div>


                  </div>
              </form>
              </div>
            </div>

      </div>

    </div>



<div class="row" style="    margin-right: 5px;">
 <div class="col-lg-6">

      <h4><?php _e('Blocked IPs', 'sfa-brute-force'); ?></h4>
      <table class="wp-list-table widefat fixed">
          <thead>
              <tr>
                  <th width="5%">#</th>
                  <th width="30%"><?php _e('Address', 'sfa-brute-force'); ?></th>
                  <th width="65%"><?php _e('Actions', 'sfa-brute-force'); ?></th>
              </tr>
          </thead>
          <tbody>
              <?php
              $i = 1;
              foreach ($this->__htaccess->getDeniedIPs() as $deniedIP):
                  ?>
                  <tr <?php echo ($i % 2 == 0) ? 'class="even"' : ''; ?>>
                      <td><?php echo $i; ?></td>
                      <td><strong><?php echo $deniedIP ?></strong></td>
                      <td>
                          <form method="post" action="">
                              <input type="hidden" name="IP" value="<?php echo $deniedIP ?>" />
                              <input type="submit" name="unblock" value="<?php echo __('Unblock', 'sfa-brute-force'); ?>" class="button" />
                          </form>
                      </td>
                  </tr>
                  <?php
                  $i++;
              endforeach;
              ?>
              <tr <?php echo ($i % 2 == 0) ? 'class="even"' : ''; ?>>
                  <td><?php echo $i; ?></td>
          <form method="post" action="">
              <td>
                  <input type="text" name="IP" placeholder="<?php _e('IP to block', 'sfa-brute-force'); ?>" required />
              </td>
              <td>
                  <input type="submit" name="block" value="<?php _e('Manually block IP', 'sfa-brute-force'); ?>" class="button button-primary" />
              </td>
          </form>
          </tr>
          </tbody>
      </table>
  </div>
  <div class="col-lg-6">
    <h4><?php _e('Whitelisted IPs', 'sfa-brute-force'); ?></h4>
    <table class="wp-list-table widefat fixed">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="30%"><?php _e('Address', 'sfa-brute-force'); ?></th>
                <th width="65%"><?php _e('Actions', 'sfa-brute-force'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $currentIP = $this->__getClientIP();

            $i = 1;
            $whitelist = $this->__getWhitelist();
            foreach ($whitelist as $whitelistedIP):
                ?>
                <tr <?php echo ($i % 2 == 0) ? 'class="even"' : ''; ?>>
                    <td><?php echo $i; ?></td>
                    <td><strong><?php echo $whitelistedIP ?></strong></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="IP" value="<?php echo $whitelistedIP ?>" />
                            <input type="submit" name="unwhitelist" value="<?php echo __('Remove from whitelist', 'sfa-brute-force'); ?>" class="button" />
                        </form>
                    </td>
                </tr>
                <?php
                $i++;
            endforeach;
            ?>
            <tr <?php echo ($i % 2 == 0) ? 'class="even"' : ''; ?>>
                <td><?php echo $i; ?></td>
        <form method="post" action="">
            <td>
                <input type="text" name="IP" placeholder="<?php _e('IP to whitelist', 'sfa-brute-force'); ?>" required />
            </td>
            <td>
                <input type="submit" name="whitelist" value="<?php _e('Add to whitelist', 'sfa-brute-force'); ?>" class="button button-primary" />
                <?php if (!in_array($currentIP, $whitelist)): ?>
                    &nbsp;<a href="javascript:WhitelistCurrentIP()" class="button"><?php printf(__('Whitelist my current IP (%s)', 'sfa-brute-force'), $currentIP); ?></a>
                <?php endif; ?>
            </td>
        </form>
        </tr>
        </tbody>
    </table>

    <form id="reset_form" method="post" action="">
        <input type="hidden" name="reset" value="true" />
    </form>

    <form id="whitelist_current_ip_form" method="post" action="">
        <input type="hidden" name="whitelist" value="true" />
        <input type="hidden" name="IP" value="<?php echo $currentIP; ?>" />
    </form>
  </div>


</div>



</div>
</div>
</div>

<? layout_import('footer'); ?>
