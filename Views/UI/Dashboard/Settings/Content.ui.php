<div class="metabox-holder">
	<div class="wf-block" data-persistence-key="waf-options-advanced">
		<div class="wf-block-header" style="cursor: pointer;">
			<div class="wf-block-header-content">
				<div class="wf-block-title"> <strong><i class="ti-receipt"></i> &nbsp; <?php _e('Content Protection', 'sfa-guard'); ?></strong>
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
             <input type="checkbox" id="SFA_TCProtection" name="SFA_TCProtection" value="true" <?php echo ($controller->__options['TCProtection']) ? 'checked' : ''; ?>>
             <label class="form-check-label" for="SFA_TCProtection"><?php _e('Enable Content Protection', 'sfa-guard'); ?>
               <br><small class="form-text text-muted pl10">
                 <?php _e('If Enabled, When Some one copies your content, The content will be replaced with a message', 'sfa-guard'); ?></small>
             </label>
            </div>
          </div>
        </li>

        <li style="min-height:70px;  padding:10px;">
				<div class="col-md-6">
					<div>
						<label class="form-check-label" for="SFA_TCProtection_msg">
							<?php _e( 'Protected Content Message', 'sfa-guard'); ?>
						</label><br>
						 <small id="SFA_TCProtection_msg" class="form-text text-muted ">
                     <?php _e('When Content Protection Enabled & Someone Copied Your content, The Content will be replaced with this text', 'sfa-guard'); ?>
            </small>
					</div>
				</div>
        <div class="col-md-6">
          <input type="text" class="form-control" aria-describedby="SFA_TCProtection_msg" id="SFA_TCProtection_msg" name="SFA_TCProtection_msg" value="<?php echo $controller->__options['TCProtection_msg']; ?>">
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
