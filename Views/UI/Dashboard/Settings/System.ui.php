<div class="metabox-holder">
	<div class="wf-block" data-persistence-key="waf-options-advanced">
		<div class="wf-block-header" style="cursor: pointer;">
			<div class="wf-block-header-content">
				<div class="wf-block-title"> <strong><i class="ti-server"></i> &nbsp; <?php _e('System & Core Options', 'sfa-guard'); ?></strong>
				</div>
				<div class="wf-block-header-action">
					<div class="wf-block-header-action-disclosure"></div>
				</div>
			</div>
		</div>
		<div class="wf-block-content" style="display: none;">
			<ul class="wf-block-list">
        <li style="padding-top:10px;">
          <div class="col-md-12">
            <div class="checkbox">
             <input type="checkbox" id="SFA_Maintenance" name="SFA_Maintenance" value="true" <?php echo ($controller->__options['Maintenance']) ? 'checked' : ''; ?>>
             <label class="form-check-label" for="SFA_Maintenance"><?php _e('Enable Maintenance Mode', 'sfa-guard'); ?>
               <br><small class="form-text text-muted pl10">
                 <?php _e('Maintenance mode allows Skytells Guard to close the site for maintenance time or launch a coming soon page.', 'sfa-guard'); ?></small>
             </label>
            </div>
          </div>
        </li>

        <li style="min-height:70px;  padding:10px;">
				<div class="col-md-6">
					<div>
						<label class="form-check-label" for="SFA_MaintenanceMessage">
							<?php _e( 'Maintenance Message', 'sfa-guard'); ?>
						</label><br>
						 <small id="SFA_MaintenanceMessage" class="form-text text-muted ">
                     <?php _e('This message will appear to your visitors when maintenance mode being enabled', 'sfa-guard'); ?><br>
										 <?php _e('You can use HTML formatting for this message', 'sfa-guard'); ?>
            </small>
					</div>
				</div>
        <div class="col-md-6">
          <textarea type="text" rows='3' style="height:70px;" class="form-control" aria-describedby="SFA_MaintenanceMessage" id="SFA_MaintenanceMessage" name="SFA_MaintenanceMessage" ><?php echo $controller->__options['MaintenanceMessage']; ?></textarea>
        </div>
        </li>


				<li>
				<div class="form-row">
				<h5 class="panel-h5">System Updates <label class="badge badge-warning" style="background:#f5a500; padding: 3px 5px; font-size: 10px;">Pro</label></h5>
				@if (\Skytells\SFA::CL())

				<div class="col-md-12">
					<div class="checkbox">
					 <input type="checkbox" id="SFA_CORE_UPDATES" name="SFA_CORE_UPDATES" value="true" <?php echo ($controller->__options['CORE_UPDATES']) ? 'checked' : ''; ?>>
					 <label class="form-check-label" for="SFA_CORE_UPDATES"><?php _e('Enable Automatic Core Updates', 'sfa-guard'); ?><br><small class="form-text text-muted pl10">
						 <?php _e('If Enabled, Skytells Guard will update your WordPress core automatically when WP has an update.', 'sfa-guard'); ?></small></label>

					</div>
				</div>
				</div>
				</li>

				<li>
				<div class="col-md-12">
					<div class="checkbox">
					 <input type="checkbox" id="SFA_PLUGINS_UPDATES" name="SFA_PLUGINS_UPDATES" value="true" <?php echo ($controller->__options['PLUGINS_UPDATES']) ? 'checked' : ''; ?>>
					 <label class="form-check-label" for="SFA_PLUGINS_UPDATES"><?php _e('Update Plugins Automatically', 'sfa-guard'); ?>
						 <br><small class="form-text text-muted pl10">
							 <?php _e('If Enabled, Skytells Guard will update your plugins automatically to the latest stable releases', 'sfa-guard'); ?></small>
					 </label>
					</div>
				</div>
				</li>


				<li>
				<div class="col-md-12">
					<div class="checkbox">
					 <input type="checkbox" id="SFA_THEMES_UPDATES" name="SFA_THEMES_UPDATES" value="true" <?php echo ($controller->__options['THEMES_UPDATES']) ? 'checked' : ''; ?>>
					 <label class="form-check-label" for="SFA_PLUGIN_UPDATES"><?php _e('Update Themes Automatically', 'sfa-guard'); ?>
						 <br><small class="form-text text-muted pl10">
							 <?php _e('If Enabled, Skytells Guard will update your themes automatically to the latest stable releases', 'sfa-guard'); ?></small>
					 </label>
					</div>
				</div>
				</li>



			@else
				<div class="col-md-12">
					<div class="checkbox">
					 <input disabled type="checkbox" id="SFA_CORE_UPDATES" name="SFA_CORE_UPDATES" value="false" <?php echo ($controller->__options['CORE_UPDATES']) ? 'checked' : ''; ?>>
					 <label class="form-check-label" for="SFA_CORE_UPDATES"><?php _e('Enable Automatic Core Updates', 'sfa-guard'); ?><br><small class="form-text text-muted pl10">
						 <?php _e('If Enabled, Skytells Guard will update your WordPress core automatically when WP has an update.', 'sfa-guard'); ?></small></label>

					</div>
				</div>
				</div>
				</li>

				<li>
				<div class="col-md-12">
					<div class="checkbox">
					 <input disabled type="checkbox" id="SFA_PLUGINS_UPDATES" name="SFA_PLUGINS_UPDATES" value="false" <?php echo ($controller->__options['PLUGINS_UPDATES']) ? 'checked' : ''; ?>>
					 <label class="form-check-label" for="SFA_PLUGINS_UPDATES"><?php _e('Update Plugins Automatically', 'sfa-guard'); ?>
						 <br><small class="form-text text-muted pl10">
							 <?php _e('If Enabled, Skytells Guard will update your plugins automatically to the latest stable releases', 'sfa-guard'); ?></small>
					 </label>
					</div>
				</div>
				</li>


				<li>
				<div class="col-md-12">
					<div class="checkbox">
					 <input disabled type="checkbox" id="SFA_THEMES_UPDATES" name="SFA_THEMES_UPDATES" value="false" <?php echo ($controller->__options['THEMES_UPDATES']) ? 'checked' : ''; ?>>
					 <label class="form-check-label" for="SFA_PLUGIN_UPDATES"><?php _e('Update Themes Automatically', 'sfa-guard'); ?>
						 <br><small class="form-text text-muted pl10">
							 <?php _e('If Enabled, Skytells Guard will update your themes automatically to the latest stable releases', 'sfa-guard'); ?></small>
					 </label>
					</div>
				</div>
				</li>


			@endif


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
