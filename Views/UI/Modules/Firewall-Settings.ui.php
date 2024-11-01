
<div class="wf-row">
	<div class="wf-col-xs-12">
		<div class="wf-block wf-active" data-persistence-key="waf-options-advanced">
			<div class="wf-block-header" style="cursor: pointer;">
				<div class="wf-block-header-content">
					<div class="wf-block-title">
						<strong>Firewall Settings</strong>
					</div>
					<div class="wf-block-header-action">
						<div class="wf-block-header-action-disclosure"></div>
					</div>
				</div>
			</div>
			<div class="wf-block-content" style="display: block;">
				<ul class="wf-block-list">
					<li>
            <div class="checkbox-info mac">

            <input name="skfw_status" type="checkbox" <?php echo ($options['status']) ? 'checked' : ''; ?> id="skfw_status" class="regular-checkbox mac f-normal" />
            <label for="skfw_status"></label>
            <label class="form-check-label f-normal" for="skfw_status"> <?php _e('Enable Firewall', 'sfa-firewall'); ?>
              <a href="#" title="<?=_e("If Enabled, The Firewall will start performing its functionality.");?>" class="tippy">
                <span class="dashicons dashicons-editor-help skyav-info-toggle help-icon m4px"></span>
              </a>
            </label>
            <small class="form-text text-muted" style="padding-left:6px;">
              <?php _e('This Option Enables or Disables the Firewall, Also, Please make sure to enable The Firewall Modules from Skytells Guard Settings.', 'sfa-firewall'); ?>
            </small>
          </div>
					</li>






          <li>
            <div class="checkbox-info mac">

            <input name="skfw_ddos_status" type="checkbox" <?php echo ($options['ddos_status']) ? 'checked' : ''; ?> id="skfw_ddos_status" class="regular-checkbox mac f-normal" />
            <label for="skfw_ddos_status"></label>
            <label class="form-check-label f-normal" for="skfw_ddos_status"> <?php _e('Enable DDoS Attacks Protection', 'sfa-firewall'); ?>
              <a href="#" title="<?=_e("If Enabled, The Firewall will start performing an AI algorithms to check each incoming request.");?>" class="tippy">
                <span class="dashicons dashicons-editor-help skyav-info-toggle help-icon m4px"></span>
              </a>
            </label>
            <small class="form-text text-muted" style="padding-left:6px;">
              <?php _e('Make sure to fill out the max requests per IP per sec. from Advanced Section', 'sfa-firewall'); ?>
            </small>
          </div>
					</li>

          <li>
            <div class="checkbox-info mac">

            <input name="skfw_send_email" type="checkbox" <?php echo ($options['send_email']) ? 'checked' : ''; ?> id="skfw_send_email" class="regular-checkbox mac f-normal" />
            <label for="skfw_send_email"></label>
            <label class="form-check-label f-normal" for="skfw_send_email"> <?php _e('Notify me if an attacker performed an attack on my site.', 'sfa-firewall'); ?>
              <a href="#" title="<?=_e("If Enabled, The Firewall will send you an email notifications upon detecting any attacks");?>" class="tippy">
                <span class="dashicons dashicons-editor-help skyav-info-toggle help-icon m4px"></span>
              </a>
            </label>
            <small class="form-text text-muted" style="padding-left:6px;">
              <?php _e('Recommeded to be on.', 'sfa-firewall'); ?>
            </small>
          </div>
          </li>



          <li>
          <div class="col-md-12">
              <? if (\Skytells\SFA::CL()) : ?>
              <?php submit_button(__('Save', 'sfa-firewall'), 'primary', 'submit', false); ?>&nbsp;

              <a href="javascript:ResetOptions()" class="button">
                <?php _e('Reset', 'sfa-firewall'); ?>
              </a>
              <? else: ?>
              <small class="form-pro-req">You need to have a Pro License to Enable These settings.</small>
              <? endif; ?>
            </div>
          </li>

				</div>
			</div>
		</div>
	</div>
