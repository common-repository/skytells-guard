<div class="metabox-holder">
	<div class="wf-block" data-persistence-key="waf-options-advanced">
		<div class="wf-block-header" style="cursor: pointer;">
			<div class="wf-block-header-content">
				<div class="wf-block-title"> <strong><i class="ti-cloud"></i> &nbsp; <?php _e('CloudFlare Settings', 'sfa-guard'); ?></strong>
				</div>
				<div class="wf-block-header-action">
					<div class="wf-block-header-action-disclosure"></div>
				</div>
			</div>
		</div>
		<div class="wf-block-content" style="display: none;">
			<ul class="wf-block-list">
        @if (!\Skytells\SFA::CL())
          <li style="min-height:70px; padding-top:10px;">

                <div class="alert alert-warning">
                  <button type="button" aria-hidden="true" class="close">×</button>
                  <strong><b>Limited Access (Disabled Feature)</b></strong>
                    <span><b> Warning - </b> You're currently running on a FREE license while The CloudFlare Feature needs a Pro license to perform its own functions.</span>
                    <span>Please keep in mind that CloudFlare Syncing will not perform it's functionality on the FREE version.</span>
                    <span style="padding-top:4px;"><b><a href="<?=SFA_PRO_PURCHASE;?>" target="_blank">Click Here to Purchase A Pro License</a></b></span>
            </div>
          </li>
        @else
        <li style="padding-top:10px;">
          <div class="col-md-12">
            <div class="checkbox">
             <input type="checkbox" id="SFA_cloudflare" name="SFA_cloudflare" value="true" <?php echo ($controller->__options['cloudflare']) ? 'checked' : ''; ?>>
             <label class="form-check-label" for="SFA_cloudflare"><?php _e('Enable CloudFlare Integration', 'sfa-guard'); ?>
               <br><small class="form-text text-muted pl10">
                 <?php _e('If Enabled, All security rules will be in sync with CloudFlare Networks', 'sfa-guard'); ?></small>
             </label>
            </div>
          </div>
        </li>


        <li style="min-height:50px; padding:10px;">
          <div class="col-md-6">
  					<div>
  						<label class="form-check-label" for="SFA_cloudflare_email">
  							<?php _e( 'CloudFlare E-Mail', 'sfa-guard'); ?>
                <br>
  						 <small class="form-text text-muted">
                       <?php _e('Please write your CloudFlare E-Mail, This option is required in order to activate this feature', 'sfa-guard'); ?>
              </small>
              </label>
  					</div>
  				</div>
          <div class="col-md-6">
            <input type="text" class="form-control" id="SFA_cloudflare_email" name="SFA_cloudflare_email" value="<?php echo $controller->__options['cloudflare_email']; ?>">
          </div>
        </li>


        <li style="min-height:50px; padding:10px;">
          <div class="col-md-6">
  					<div>
  						<label class="form-check-label" for="SFA_cloudflare_key">
  							<?php _e( 'CloudFlare API Key', 'sfa-guard'); ?>
                <br>
  						 <small class="form-text text-muted">
                       <?php _e('The CloudFlare API key used for authenticate your account with Skytells Guard. <a href="https://www.cloudflare.com/a/profile" target="_blank">Get API Key</a>', 'sfa-guard'); ?>
              </small>
              </label>
  					</div>
  				</div>
          <div class="col-md-6">
            <input type="text" class="form-control" id="SFA_cloudflare_key" name="SFA_cloudflare_key" value="<?php echo $controller->__options['cloudflare_key']; ?>">
          </div>
        </li>

        <li style="min-height:50px; padding:10px;">
          <div class="col-md-6">
            <div>
              <label class="form-check-label" for="SFA_cloudflare_zoneid">
                <?php _e( 'Zone ID', 'sfa-guard'); ?>
                <br>
               <small class="form-text text-muted">
                       <?php _e('The CloudFlare Zone identfier for this domain', 'sfa-guard'); ?>
              </small>
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control" id="SFA_cloudflare_zoneid" name="SFA_cloudflare_zoneid" value="<?php echo $controller->__options['cloudflare_zoneid']; ?>">
          </div>
        </li>



        <li style="">
         <div class="form-row">
          <h5 class="panel-h5">Permissions</h5>

          <div class="col-md-12">
            <div class="checkbox">
             <input type="checkbox" id="SFA_cloudflare_syncBans" name="SFA_cloudflare_syncBans" value="true" <?php echo ($controller->__options['cloudflare_syncBans']) ? 'checked' : ''; ?>>
             <label class="form-check-label" for="SFA_cloudflare_syncBans"><?php _e('Sync Firewall IP Bans with CloudFlare', 'sfa-guard'); ?>
               <br><small class="form-text text-muted pl10">
                 <?php _e('Should we tell CloudFlare to ban the same IP that blocked by Skytells Guard?', 'sfa-guard'); ?></small>
             </label>
            </div>
          </div>
        </div>
        </li>

        <li style="">
          <div class="col-md-12">
            <div class="checkbox">
             <input type="checkbox" id="SFA_cloudflare_syncBruteForce" name="SFA_cloudflare_syncBruteForce" value="true" <?php echo ($controller->__options['cloudflare_syncBruteForce']) ? 'checked' : ''; ?>>
             <label class="form-check-label" for="SFA_cloudflare_syncBruteForce"><?php _e('Sync Brute-Force Bans with CloudFlare', 'sfa-guard'); ?>
               <br><small class="form-text text-muted pl10">
                 <?php _e('Should we tell CloudFlare to ban the same IP that blocked by Skytells Brute Force Protection?', 'sfa-guard'); ?></small>
             </label>
            </div>
          </div>
        </li>

        <li style="">
          <div class="col-md-12">
            <div class="checkbox">
             <input type="checkbox" id="SFA_cloudflare_syncDDoS" name="SFA_cloudflare_syncDDoS" value="true" <?php echo ($controller->__options['cloudflare_syncDDoS']) ? 'checked' : ''; ?>>
             <label class="form-check-label" for="SFA_cloudflare_syncDDoS"><?php _e('Immediately Inform CloudFlare to handle DDoS Attacks?', 'sfa-guard'); ?>
               <br><small class="form-text text-muted pl10">
                 <?php _e('Should we tell CloudFlare to ban the same IP that blocked by Skytells Guard?', 'sfa-guard'); ?></small>
             </label>
            </div>
          </div>
        </li>




        <li>
        <div class="postbox-footer" style="">
          <?php submit_button(__( 'Save', 'sfa-settings'), 'primary', 'submit', false); ?>&nbsp;
          <a href="javascript:ResetOptions()" class="button">
            <?php _e( 'Reset', 'sfa-guard'); ?>
          </a>
        </div>
      </li>
        @endif
      </ul>
		</div>
	</div>
</div>
