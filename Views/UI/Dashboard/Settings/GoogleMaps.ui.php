<div class="metabox-holder">
	<div class="wf-block" data-persistence-key="waf-options-advanced">
		<div class="wf-block-header" style="cursor: pointer;">
			<div class="wf-block-header-content">
				<div class="wf-block-title"> <strong><i class="ti-google"></i> &nbsp; <?php _e('Google Settings', 'sfa-guard'); ?></strong>
				</div>
				<div class="wf-block-header-action">
					<div class="wf-block-header-action-disclosure"></div>
				</div>
			</div>
		</div>
		<div class="wf-block-content" style="display: none;">
			<ul class="wf-block-list">
        <li style="min-height:70px;">
				<div class="col-md-6">
					<div>
						<label class="form-check-label" for="SFA_googleMapsKey">
							<?php _e( 'Google API Key', 'sfa-guard'); ?>
						</label>
						 <small id="sdcG" class="form-text text-muted pl10">
                     <?php _e('Google Maps API Key is required for displaying geo charts!. <a href="https://developers.google.com/maps/documentation/javascript/get-api-key">GET API KEY</a>', 'sfa-guard'); ?>
            </small>
					</div>
				</div>
        <div class="col-md-6">
          <input type="text" class="form-control" aria-describedby="sdcG" id="SFA_googleMapsKey" name="SFA_googleMapsKey" value="<?php echo $controller->__options['googleMapsKey']; ?>">
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
