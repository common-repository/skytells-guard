
<div class="wf-row">
	<div class="wf-col-xs-12">
		<div class="wf-block" data-persistence-key="waf-options-advanced">
			<div class="wf-block-header" style="cursor: pointer;">
				<div class="wf-block-header-content">
					<div class="wf-block-title">
						<strong>Additional Firewall Options</strong>
					</div>
					<div class="wf-block-header-action">
						<div class="wf-block-header-action-disclosure"></div>
					</div>
				</div>
			</div>
			<div class="wf-block-content" style="display: none;">
				<ul class="wf-block-list">
					<li>
            <div class="checkbox-info mac">

            <input name="skfw_force_ssl" type="checkbox" <?php echo ($options['force_ssl']) ? 'checked' : ''; ?> id="skfw_force_ssl" class="regular-checkbox mac f-normal" />
            <label for="skfw_force_ssl"></label>
            <label class="form-check-label f-normal" for="skfw_force_ssl"> <?php _e('Force SSL', 'sfa-firewall'); ?>
              <a href="#" title="<?=_e("Force SSL Redirects all insecure URLS to secure HTTPS protocol, This option requires an SSL Certificate");?>" class="tippy">
                <span class="dashicons dashicons-editor-help skyav-info-toggle help-icon m4px"></span>
              </a>
            </label>
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
