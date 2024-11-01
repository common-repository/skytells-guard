
<div class="wf-row">
	<div class="wf-col-xs-12">
		<div class="wf-block" data-persistence-key="waf-options-advanced">
			<div class="wf-block-header" style="cursor: pointer;">
				<div class="wf-block-header-content">
					<div class="wf-block-title">
						<strong>Advanced Firewall Options</strong>
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

            <input name="skfw_block_fake_googlebots" type="checkbox" <?php echo ($options['block_fake_googlebots']) ? 'checked' : ''; ?> id="block_fake_googlebots" class="regular-checkbox mac f-normal" /><label for="block_fake_googlebots"></label>
            <label class="form-check-label f-normal" for="block_fake_googlebots"> <?php _e('Immediately block fake Google crawlers', 'sfa-firewall'); ?>
              <a href="#" title="If you are having a problem with people stealing your content and pretending to be Google as they crawl your site, then you can enable this option which will immediately block anyone pretending to be Google." class="tippy">
                <span class="dashicons dashicons-editor-help skyav-info-toggle help-icon m4px"></span>
              </a>
            </label>
          </div>
					</li>



          <li>
            <div class="checkbox-info mac">

            <input name="skfw_block_empty_ref_ips" type="checkbox" <?php echo ($options['block_empty_ref_ips']) ? 'checked' : ''; ?> id="block_empty_ref_ips" class="regular-checkbox mac f-normal" /><label for="block_empty_ref_ips"></label>
            <label class="form-check-label f-normal" for="block_empty_ref_ips"> <?php _e('Block IPs who send POST requests with blank User-Agent and Referer', 'sfa-firewall'); ?>
              <a href="#" title="Many badly written brute force hacking scripts send login attempts and comment spam attempts using a blank user agent (in other words, they don’t specify which browser they are) and blank referer headers (in other words, they don’t specify which URL they arrived from). Enabling this option will not only prevent requests like this from reaching your site, but it will also immediately block the IP address the request originated from." class="tippy">
                <span class="dashicons dashicons-editor-help skyav-info-toggle help-icon m4px"></span>
              </a>
            </label>
          </div>
					</li>

					<li>
						<div class="checkbox-info mac">

						<input name="skfw_ddos_block_ip" type="checkbox" <?php echo ($options['ddos_block_ip']) ? 'checked' : ''; ?> id="skfw_ddos_block_ip" class="regular-checkbox mac f-normal" />
						<label for="skfw_ddos_block_ip"></label>
						<label class="form-check-label f-normal" for="skfw_ddos_block_ip"> <?php _e("Immediately block DDoS Attacker's IP", 'sfa-firewall'); ?>
							<a href="#" title="Incase of you got hit by DDoS Attack, You can enable this option to Immediately BLOCK the IP from connecting to the server after a specified requests" class="tippy">
								<span class="dashicons dashicons-editor-help skyav-info-toggle help-icon m4px"></span>
							</a>
						</label>
					</div>
					</li>


          <li>
            <div class="checkbox-info mac">

            <input name="skfw_block_ip_notification" type="checkbox" <?php echo ($options['block_ip_notification']) ? 'checked' : ''; ?> id="skfw_block_ip_notification" class="regular-checkbox mac f-normal" /><label for="block_empty_ref_ips"></label>
            <label class="form-check-label f-normal" for="skfw_block_ip_notification"> <?php _e('Send A Notification e-mail to me If an IP got blocked', 'sfa-firewall'); ?>
              <a href="#" title="If Enabled, Skytells Guard will send you an email notification if an IP got blocked" class="tippy">
                <span class="dashicons dashicons-editor-help skyav-info-toggle help-icon m4px"></span>
              </a>
            </label>
          </div>
					</li>




          <li>
            <div class="wf-row" style="margin-top:12px; margin-bottom:8px;">
              <div class="col-md-6">
                <label class="f-normal">
                  <?php _e('Allowed Chars Pattern'); ?>
                </label><br>
              <small class="form-text text-muted">Write the RegEx Pattern for the allowed chars, Requires RegEx Skills.</small>
               </div>
                 <div class="col-md-6">
                  <input  class="form-control" type="text" rows="1" name="skfw_allowedchars" value="<?php echo $options['allowedchars']; ?>" style="color:#b53caa;">
                </div>
            </div>
          </li>

          <li>
            <div class="wf-row" style="margin-top:12px; margin-bottom:8px;">
              <div class="col-md-6">
                <label class="f-normal">
                  <?php _e('Max Requests Per Second Per IP'); ?>
                </label><br>
              <small class="form-text text-muted">If DDoS Attacks Protection Enabled, Set the maximum request allowed per sec.</small>
               </div>
                 <div class="col-md-6">
                  <input  type="number" min="1" max="100" class="form-control" type="text" rows="1" name="skfw_ddos_exp" value="<?php echo $options['ddos_exp']; ?>">
                </div>
            </div>
          </li>


					<li>
            <div class="wf-row" style="margin-top:12px; margin-bottom:8px;">
              <div class="col-md-6">
                <label class="f-normal">
                  <?php _e('How many DDoS tries allowed before Blocking the IP?'); ?>
                </label><br>
              <small class="form-text text-muted">If DDoS Attacks Protection and DDoS Attacker IP Blocking are Enabled, Set the maximum attacks allowed before we block the IP</small>
               </div>
                 <div class="col-md-6">
                  <input  type="number" min="2" max="100" class="form-control" type="text" rows="1" name="skfw_ddos_tries" value="<?php echo $options['ddos_tries']; ?>">
                </div>
            </div>
          </li>

					<li>
						<div class="wf-row" style="margin-top:12px; margin-bottom:8px;">
							<div class="col-md-6">
								<label class="f-normal">
									<?php _e('Default Expiry Period for DDoS Requests'); ?>   <a href="#" title="Tell Us, How long should we reset the session if we detected an DDoS Attack?" class="tippy">
											<span class="dashicons dashicons-editor-help skyav-info-toggle help-icon m4px"></span>
										</a>
								</label><br>
							<small class="form-text text-muted"><?= _e('How long should we reset the session for an IP when we detect a DDoS Attack? (In Seconds) <br>Examples : 10, 60, 120, 1000');?></small>
							 </div>
								 <div class="col-md-6">
									<input class="form-control" type="number" min='10' max='9999' rows="1" name="skfw_DDoS_Tries_Expiry" value="<?php echo $options['DDoS_Tries_Expiry']; ?>">
								</div>
						</div>
					</li>


					<li>
            <div class="wf-row" style="margin-top:12px; margin-bottom:8px;">
              <div class="col-md-6">
                <label class="f-normal">
                  <?php _e('Default Expiry Period for IP Bans'); ?>   <a href="#" title="Here you can tell us how long you want us to keep the banned IPs in blacklist? This option tells the Automotion systems to ban the IP for a limited time, Example of use : 1 hour, 1 day ({Number} {String}) or you can write 0 to keep it in blacklist for ever!" class="tippy">
			                <span class="dashicons dashicons-editor-help skyav-info-toggle help-icon m4px"></span>
			              </a>
                </label><br>
              <small class="form-text text-muted"><?= _e('How long should an IP being banned?<br>Examples : 50 secounds, 3 minutes, 3 hours, 1 days.. etc');?></small>
               </div>
                 <div class="col-md-6">
                  <input class="form-control" type="text" rows="1" name="skfw_IPBanExpiry" value="<?php echo $options['IPBanExpiry']; ?>">
                </div>
            </div>
          </li>


          <li>
            <div class="wf-row" style="margin-top:12px; margin-bottom:8px;">
              <div class="col-md-6">
                <label class="f-normal">
                  <?php _e('Whitelisted IP addresses that bypass all rules'); ?>
                </label><br>
              <small class="form-text text-muted">Whitelisted IPs must be separated by commas or placed on separate lines.<br>Example: 127.0.0.1,127.0.0.2</small>
               </div>
                 <div class="col-md-6">
                  <textarea  class="form-control" type="text" rows="1" name="skfw_whitelisted_ips" style="max-height:55px;"><?php echo $options['whitelisted_ips']; ?></textarea>
                </div>
            </div>
          </li>



          <li>
            <div class="wf-row" style="margin-top:12px; margin-bottom:8px;">
              <div class="col-md-6">
                <label class="f-normal">
                  <?php _e('Whitelisted URL(s)'); ?>
                </label><br>
              <small class="form-text text-muted">Whitelisted URLs must be separated by commas or placed on separate lines.<br>Example: domain.com,domain2.com/e/</small>
               </div>
                 <div class="col-md-6">
                  <textarea  class="form-control" type="text" rows="1" name="skfw_whitelisted" style="max-height:55px;"><?php echo $options['whitelisted']; ?></textarea>
                </div>
            </div>
          </li>


          <li>
            <div class="wf-row" style="margin-top:12px; margin-bottom:8px;">
              <div class="col-md-6">
                <label class="f-normal">
                  <?php _e('Immediately block IPs that access these URLs'); ?>
                </label><br>
              <small class="form-text text-muted">Separate multiple URLs with commas or place them on separate lines. Asterisks are wildcards, but use with care. If you see an attacker repeatedly probing your site for a known vulnerability you can use this to immediately block them. </small>
               </div>
                 <div class="col-md-6">
                  <textarea  class="form-control" type="text" rows="1" name="skfw_protected_urls" style="max-height:65px;"><?php echo $options['protected_urls']; ?></textarea>
                </div>
            </div>
          </li>



          <li>
            <div class="wf-row" style="margin-top:12px; margin-bottom:8px;">
              <div class="col-md-6">
                <label class="f-normal">
                  <?php _e('Firewall Detection Page Content'); ?>
                </label><br>
              <small class="form-text text-muted">This HTML Message will appear when detecting an SQL Injection attack!<br>HTML is allowed.</small>
               </div>
                 <div class="col-md-6">
                  <textarea  class="form-control" type="text" rows="1" name="skfw_blockedmessage" style="max-height:75px;"><?php echo $options['blockedmessage']; ?></textarea>
                </div>
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
