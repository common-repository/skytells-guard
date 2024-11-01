
<nav class="site-navbar">
  <div class="row">
    <div class="col-xs-9">
  <ul class="site-navbar-list">

     <li ng-repeat="item in ::menuItems" class="site-navbar-list-item ng-scope" ng-class="::{'with-sub-menu': item.subMenu}" ui-sref-navbar-active="selected" ba-navbar-toggling-item="item">
       <a ng-if="::!item.subMenu" class="site-navbar-list-link ng-scope" ui-state="item.stateRef || ''" ng-href="" href="#/dashboard"><i class="fa fa-tachometer"></i><span class="ng-binding">Dashboard</span></a><!-- end ngIf: ::!item.subMenu --> <!-- ngIf: ::item.subMenu --><!-- ngIf: ::item.subMenu -->
     </li>

     <li ng-repeat="item in ::menuItems" class="site-navbar-list-item ng-scope with-sub-menu" ng-class="::{'with-sub-menu': item.subMenu}" ui-sref-navbar-active="selected" ba-navbar-toggling-item="item">

        <a data-toggle="dropdown" class="site-navbar-list-link ng-scope" ba-ui-sref-navbar-toggler="">
           <i class="fa fa-search"></i><span class="ng-binding">Scanner</span>
           <b class="fa fa-angle-down ng-scope" ui-sref-navbar-active="fa-angle-up" ng-if="::item.subMenu"></b>

        </a>

        <ul class="dropdown-menu">
          <li><a href="admin.php?page=sfa-scanner">Perform Scan</a></li>

        </ul>
     </li>
     <li ng-repeat="item in ::menuItems" class="site-navbar-list-item ng-scope with-sub-menu" ng-class="::{'with-sub-menu': item.subMenu}" ui-sref-navbar-active="selected" ba-navbar-toggling-item="item">
        <a data-toggle="dropdown" ng-if="::item.subMenu" class="site-navbar-list-link ng-scope" ba-ui-sref-navbar-toggler="">
           <i class="fa fa-wrench"></i><span class="ng-binding">Tools</span> <!-- ngIf: ::item.subMenu --><b class="fa fa-angle-down ng-scope" ui-sref-navbar-active="fa-angle-up" ng-if="::item.subMenu"></b><!-- end ngIf: ::item.subMenu -->
        </a>



        <ul class="dropdown-menu">
          <li><a href="admin.php?page=sfa-firewall">AI-Powered Firewall</a></li>
        <li><a href="admin.php?page=sfa-brute-force">Brute Force Protection</a></li>
          <li><a href="admin.php?page=sfa-metainfo-protection">MetaTags & Info Remover</a></li>
          <li><a href="admin.php?page=skyav-exploits">Expolits Detector</a></li>
          <li><a href="admin.php?page=sfa-analysis">Security Analysis</a></li>
          <li><a href="admin.php?page=sfa-recaptcha">reCAPTCHA Options</a></li>

        </ul>

     </li>
     <li ng-repeat="item in ::menuItems" class="site-navbar-list-item ng-scope" ng-class="::{'with-sub-menu': item.subMenu}" ui-sref-navbar-active="selected" ba-navbar-toggling-item="item">
      <a ng-if="::!item.subMenu" class="site-navbar-list-link ng-scope" ui-state="item.stateRef || ''" ng-href="" href="admin.php?page=sfa-settings"><i class="fa fa-cogs"></i><span class="ng-binding">Settings</span></a><!-- end ngIf: ::!item.subMenu --> <!-- ngIf: ::item.subMenu --><!-- ngIf: ::item.subMenu -->
     </li>
  </ul>

</div>

  <div class="col-xs-3">
  <? if (!\Skytells\SFA::CL()): ?>
    <h5 class="not-protected"><i class="fa fa-ban text-success" style="color:#ff6565;"></i> <?php _e("YOU'RE NOT PROTECTED"); ?>
      <a href="#"  title="You do not have a PRO license, A lot of features are currently disabled, Please purchase the PRO license as soon as possible." data-toggle="tooltip">
        <span class="dashicons dashicons-editor-help skyav-info-toggle help-icon"></span></a>
    </h5>
  <? elseif ((bool)get_option('SFA_firewall') == false): ?>
    <h5 class="not-protected"><i class="fa fa-ban text-success" style="color:#ff6565;"></i> <?php _e("YOU'RE NOT PROTECTED"); ?>
      <a href="#"  title="The Firewall must be ON in order to protect your website!" data-toggle="tooltip">
        <span class="dashicons dashicons-editor-help skyav-info-toggle help-icon"></span></a>
    </h5>

  <? elseif ((bool)get_option('SFA_bruteforce') != true): ?>
    <h5 class="not-protected"><i class="fa fa-ban text-success" style="color:#ff6565;"></i> <?php _e('YOU ARE NOT PROTECTED'); ?>
      <a href="#"  title="The Brute-Force is currently disabled, and its must be ON in order to protect your website!" data-toggle="tooltip">
        <span class="dashicons dashicons-editor-help skyav-info-toggle help-icon"></span></a>
    </h5>


  <? elseif ((bool)get_option('SFA_CustomUrls') != true): ?>
    <h5 class="not-protected"><i class="fa fa-ban text-success" style="color:#ff6565;"></i> <?php _e('YOU ARE NOT PROTECTED'); ?>
      <a href="#"  title="The Sensitive Urls is currently OFF, Please Enable Sensitive Urls Protection from Settings." data-toggle="tooltip">
        <span class="dashicons dashicons-editor-help skyav-info-toggle help-icon"></span></a>
    </h5>

  <? elseif ((bool)get_option('SFA_disable_JSONAPI') != true): ?>
    <h5 class="not-protected"><i class="fa fa-ban text-success" style="color:#ff6565;"></i> <?php _e('YOU ARE NOT PROTECTED'); ?>
      <a href="#"  title="The JSON-API is enabled to public, Please Disable JSONAPI from Settings." data-toggle="tooltip">
        <span class="dashicons dashicons-editor-help skyav-info-toggle help-icon"></span></a>
    </h5>

  <? elseif ((bool)get_option('SFA_disable_XMLRPC') != true): ?>
    <h5 class="not-protected"><i class="fa fa-ban text-success" style="color:#ff6565;"></i> <?php _e('YOU ARE NOT PROTECTED'); ?>
      <a href="#"  title="The XML-RPC is enabled to public, This could be attacked by (DDoS) Please Disable XML-RPC from Settings." data-toggle="tooltip">
        <span class="dashicons dashicons-editor-help skyav-info-toggle help-icon"></span></a>
    </h5>

  <? elseif (\Skytells\Controllers\HTTP::isSSL() != true): ?>
    <h5 class="not-protected"><i class="fa fa-ban text-success" style="color:#ff6565;"></i> <?php _e('YOU ARE NOT PROTECTED'); ?>
      <a href="#"  title="Your Website needs an SSL certificate" data-toggle="tooltip">
        <span class="dashicons dashicons-editor-help skyav-info-toggle help-icon"></span></a>
    </h5>


   <? else: ?>
    <h5 class="protected"><i class="fa fa-check text-success" style="color:#2bcd70;"></i> <?php _e('YOU ARE PROTECTED'); ?></h5>
    <? endif; ?>
  </div>
</div>

</nav>
