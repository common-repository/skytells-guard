<div class="metabox-holder">
	<div class="wf-block" data-persistence-key="waf-options-advanced">
		<div class="wf-block-header" style="cursor: pointer;">
			<div class="wf-block-header-content">
				<div class="wf-block-title">	<strong> <i class="ti-lock"></i> &nbsp;
						<?php _e('Security Settings', 'sfa-guard'); ?>
					</strong>
				</div>
				<div class="wf-block-header-action">
					<div class="wf-block-header-action-disclosure"></div>
				</div>
			</div>
		</div>
		<div class="wf-block-content" style="display: none;">
			<ul class="wf-block-list">
        <li>
          These settings are important, Please configure these settings carefully.
        </li>
				<li>
					<div class="col-md-12">
						<div class="checkbox">
							<input type="checkbox" id="disable_JSONAPI" name="SFA_disable_JSONAPI" value="true" <?php echo ($controller->__options['disable_JSONAPI']) ? 'checked' : ''; ?>>
							<label class="form-check-label" for="disable_JSONAPI">
								<?php _e( 'Disable JSON API For Public', 'sfa-guard'); ?>
								<br>	<small class="form-text text-muted pl10">
											<?php _e('Its strongly recommended to disable the JSON REST API, This makes your website secured against Cross-GET-Requests', 'sfa-guard'); ?>
										</small>
							</label>
						</div>
					</div>
				</li>

				<li>
					<div class="col-md-12">
						<div class="checkbox">
							<input type="checkbox" id="SFA_disable_JSONAPI_USERS" name="SFA_disable_JSONAPI_USERS" value="true" <?php echo ($controller->__options['disable_JSONAPI_USERS']) ? 'checked' : ''; ?>>
							<label class="form-check-label" for="SFA_disable_JSONAPI_USERS">
								<?php _e( 'Disable JSON API for Authenticated Users', 'sfa-guard'); ?>
								<br>	<small class="form-text text-muted pl10">
											<?php _e('This Option allows you to enable or disable JSON API for authenticated users.', 'sfa-guard'); ?>
										</small>
							</label>
						</div>
					</div>
				</li>

				<li>
					<div class="col-md-12">
						<div class="checkbox">
							<input type="checkbox" id="disable_XMLRPC" name="SFA_disable_XMLRPC" value="true" <?php echo ($controller->__options['disable_XMLRPC']) ? 'checked' : ''; ?>>
							<label class="form-check-label" for="disable_XMLRPC">
								<?php _e( 'Disable XML-RPC', 'sfa-guard'); ?>
								<br>	<small class="form-text text-muted pl10">
													<?php _e('Its strongly recommended to disable the XML-RPC Just to Prevent DDoS Attacks', 'sfa-guard'); ?>
												</small>
							</label>
						</div>
					</div>
				</li>

				<li>
					<div class="col-md-12">
						<div class="checkbox">
							<input type="checkbox" id="Disable_X_PingBack" name="SFA_Disable_X_PingBack" value="true" <?php echo ($controller->__options['Disable_X_PingBack']) ? 'checked' : ''; ?>>
							<label class="form-check-label" for="Disable_X_PingBack">
								<?php _e( 'Disable X-Pingback', 'sfa-guard'); ?>
								<br>	<small class="form-text text-muted pl10">
													<?php _e('Pingback is a method for web authors to request notification when somebody links to one of their documents, Tick this to Protect WP Against X-Pingback Attacks', 'sfa-guard'); ?>
												</small>
							</label>
						</div>
					</div>
				</li>


				<li>
					<div class="col-md-12">
						<div class="checkbox">
							<input type="checkbox" id="monitor_logins" name="SFA_monitor_logins" value="true" <?php echo ($controller->__options['monitor_logins']) ? 'checked' : ''; ?>>
							<label class="form-check-label" for="monitor_logins">
								<?php _e( 'Monitor Admin Logins', 'sfa-guard'); ?>
								<br>	<small class="form-text text-muted pl10">
															<?php _e('Its strongly recommended to enable this feature', 'sfa-guard'); ?>
														</small>
							</label>
						</div>
					</div>
				</li>
				<li>
					<div class="col-md-12">
						<div class="checkbox">
							<input type="checkbox" id="SFA_loginAlerts" name="SFA_loginAlerts" value="true" <?php echo ($controller->__options['loginAlerts']) ? 'checked' : ''; ?>>
							<label class="form-check-label" for="SFA_loginAlerts">
								<?php _e( 'Send Login Notifications', 'sfa-guard'); ?>
								<br>	<small class="form-text text-muted pl10">
																	<?php _e('If Enabled, Skytells Guard will alert you for every successful login.', 'sfa-guard'); ?>
																</small>
							</label>
						</div>
					</div>
				</li>

				<li>
					<div class="col-md-12">
						<div class="checkbox">
							<input type="checkbox" id="SFA_Remove_WP_Dummy_Files" name="SFA_Remove_WP_Dummy_Files" value="true" <?php echo ($controller->__options['Remove_WP_Dummy_Files']) ? 'checked' : ''; ?>>
							<label class="form-check-label" for="SFA_Remove_WP_Dummy_Files">
								<?php _e( 'Delete Unnecessary WordPress Files', 'sfa-guard'); ?>
								<br>	<small class="form-text text-muted pl10">
													<?php _e('There are a few WordPress files that you can delete after installation. They are not needed to run any part of your site, and in one case, they reveal the WordPress version you are using, which could tip hackers off to any security vulnerabilities on your site.', 'sfa-guard'); ?>
												</small>
							</label>
						</div>
					</div>
				</li>


				<li>
					<div class="col-md-12">
						<div class="checkbox">
							<input type="checkbox" id="SFA_RSS_DISABLE" name="SFA_RSS_DISABLE" value="true" <?php echo ($controller->__options['RSS_DISABLE']) ? 'checked' : ''; ?>>
							<label class="form-check-label" for="SFA_RSS_DISABLE">
								<?php _e( 'Disable RSS Feed', 'sfa-guard'); ?>
								<br>	<small class="form-text text-muted pl10">
													<?php _e('Feeds are useful if you have regularly updated content (blog posts, comments) on your site, and you want people to be able to subscribe to those updates. If you have static pages, then they aren’t, and just add overhead to your site.', 'sfa-guard'); ?>
												</small>
							</label>
						</div>
					</div>
				</li>


				<li>
					<div class="col-md-12">
						<div class="checkbox">
							<input type="checkbox" id="branding" name="SFA_branding" value="true" <?php echo ($controller->__options['branding']) ? 'checked' : ''; ?>>
							<label class="form-check-label" for="branding">
								<?php _e( 'Branding', 'sfa-guard'); ?>
								<br>	<small class="form-text text-muted pl10">
																			<?php _e('Show Skytells-Guard Secured Badge in Footer.', 'sfa-guard'); ?>
																		</small>
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
			</ul>
		</div>
	</div>
</div>
