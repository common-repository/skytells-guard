<div class="metabox-holder">
<div class="wf-block wf-active" data-persistence-key="waf-options-advanced">
  <div class="wf-block-header" style="cursor: pointer;">
    <div class="wf-block-header-content">
      <div class="wf-block-title">
        <strong><i class="ti-package"></i> &nbsp; <?php _e('Skytells Guard Modules', 'sfa-guard'); ?></strong>
      </div>
      <div class="wf-block-header-action">
        <div class="wf-block-header-action-disclosure"></div>
      </div>
    </div>
  </div>
  <div class="wf-block-content" style="display: block;">


    <ul class="wf-block-list">


    <li>
      <div class="form-row">
        <h5 class="panel-h5">Free Modules</h5>
        <div class="col-md-12">
          <div class="checkbox">
           <input type="checkbox" id="SFA_metatags" name="SFA_metatags" value="true" <?php echo ($controller->__options['metatags']) ? 'checked' : ''; ?>>
           <label class="form-check-label" for="SFA_metatags"><?php _e('Enable MetaTags Protection', 'sfa-guard'); ?>
           <br><small class="form-text text-muted pl10">
             <?php _e('When Enabled, The Metatags Protection module will start to function.', 'sfa-guard'); ?>
           </small>
           </label>
          </div>
        </div>
      </div>
      </li>

      <li>
      <div class="col-md-12">
        <div class="checkbox">
         <input type="checkbox" id="SFA_CustomUrls" name="SFA_CustomUrls" value="true" <?php echo ($controller->__options['CustomUrls']) ? 'checked' : ''; ?>>
         <label class="form-check-label" for="SFA_CustomUrls"><?php _e('Customize Sensitive URLs', 'sfa-guard'); ?>
         <br><small class="form-text text-muted pl10">
           <?php _e('When Enabled, You can customize wp-admin and login urls from <a href="options-permalink.php" style="color:#bbbbbb;">Permalinks</a>', 'sfa-guard'); ?>
         </small>
         </label>
        </div>
      </div>
      </li>

      <li>
      <div class="col-md-12">
        <div class="checkbox">
         <input type="checkbox" id="SFA_recaptcha_module" name="SFA_recaptcha_module" value="true" <?php echo ($controller->__options['recaptcha_module']) ? 'checked' : ''; ?>>
         <label class="form-check-label" for="SFA_recaptcha_module"><?php _e('Enable reCAPTCHA on Login Pages', 'sfa-guard'); ?>
         <br><small class="form-text text-muted pl10">
           <?php _e('When Enabled, The <a href="admin.php?page=sfa-recaptcha" style="color:#bbbbbb;">reCAPTCHA</a> v2 will enabled on every sensitive login page.', 'sfa-guard'); ?>
         </small>
         </label>
        </div>
      </div>
      </li>


      <li>
      <div class="form-row">
      <h5 class="panel-h5">PRO Modules</h5>

      @if (\Skytells\SFA::CL())

      <div class="col-md-12">
        <div class="checkbox">
         <input type="checkbox" id="SFA_bruteforce" name="SFA_bruteforce" value="true" <?php echo ($controller->__options['bruteforce']) ? 'checked' : ''; ?>>
         <label class="form-check-label" for="SFA_bruteforce"><?php _e('Enable Brute-Force Protection', 'sfa-guard'); ?><br><small class="form-text text-muted pl10">
           <?php _e('A Brute Force Attack aims at being the simplest kind of method to gain access to a site: it tries usernames and passwords, over and over again, until it gets in. Brute Force Login Protection is a lightweight module that protects your website against brute force login attacks using .htaccess', 'sfa-guard'); ?></small></label>

        </div>
      </div>
      </div>
      </li>

      <li>
      <div class="col-md-12">
        <div class="checkbox">
         <input type="checkbox" id="SFA_firewall" name="SFA_firewall" value="true" <?php echo ($controller->__options['firewall']) ? 'checked' : ''; ?>>
         <label class="form-check-label" for="SFA_firewall"><?php _e('Enable Firewall', 'sfa-guard'); ?>
           <br><small class="form-text text-muted pl10">
             <?php _e('Don’t Leave Your Site At Risk, The Firewall acts as a shield between your website and all incoming traffic. These web application firewalls monitor your website traffic and blocks many common security threats before they reach your WordPress site. You must enable the Firewall Module in order to totally protect your website', 'sfa-guard'); ?></small>
         </label>
        </div>
      </div>
      </li>



    @else
    <li>
    <div class="col-md-12">
      <div class="checkbox">
       <input type="checkbox" disabled id="SFA_bruteforce" name="SFA_bruteforce" value="true" <?php echo ($controller->__options['bruteforce']) ? '' : ''; ?>>
       <label class="form-check-label" for="SFA_bruteforce"><?php _e('Enable Brute-Force Protection', 'sfa-guard'); ?><br><small class="form-text text-muted pl10">
         <?php _e('A Brute Force Attack aims at being the simplest kind of method to gain access to a site: it tries usernames and passwords, over and over again, until it gets in. Brute Force Login Protection is a lightweight module that protects your website against brute force login attacks using .htaccess', 'sfa-guard'); ?></small></label>

      </div>
    </div>

    </li>

    <li>
    <div class="col-md-12">
      <div class="checkbox">
       <input type="checkbox" disabled id="SFA_firewall" name="SFA_firewall" value="false" <?php echo ($controller->__options['firewall']) ? '' : ''; ?>>
       <label class="form-check-label" for="SFA_firewall"><?php _e('Enable Firewall', 'sfa-guard'); ?><br><small class="form-text text-muted pl10">
         <?php _e('Don’t Leave Your Site At Risk, The Firewall acts as a shield between your website and all incoming traffic. These web application firewalls monitor your website traffic and blocks many common security threats before they reach your WordPress site. You must enable the Firewall Module in order to totally protect your website', 'sfa-guard'); ?></small>
     </label>
      </div>
    </div>
    </li>


    @endif

    <li>
      <div class="postbox-footer" style="">
          <?php submit_button(__('Save', 'sfa-settings'), 'primary', 'submit', false); ?>&nbsp;
          <a href="javascript:ResetOptions()" class="button"><?php _e('Reset', 'sfa-guard'); ?></a>
      </div>
    </li>

    </ul>


  </div>
</div>
</div>
