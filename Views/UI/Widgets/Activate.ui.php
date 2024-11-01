@include('Alerts.Activated')
<?  global $SFA_SUMMARY; if (!\Skytells\SFA::A0()): ?>
<div class="row">
  <div class="col-xs-12">
<div class="panel light-text with-scroll animated zoomIn no-animation" zoom-in="">
   <div class="panel-heading clearfix">
      <h3 class="panel-title ng-binding">License Key</h3>
   </div>
   <div class="panel-body" ng-transclude="">
     <form method="post" action="">
      <settings-license class="ng-scope ng-isolate-scope">

         <div ng-if="dataLoaded" class="ng-scope" style="">
            <p class="form-group ng-binding">The Pro license enables the AI-Powered Features for Ultimate Protection!</p>
            <div class="row">

               <div class="col-xs-12 col-md-4 col-md-push-8 col-sm-5 col-sm-push-7 vertical-rule-sm-left ng-scope" ng-if="licenseResult.userinfo">
                 <button type="submit" title="Activate" class="btn btn-md btn-success btn-with-icon" >
                   <i class="ti-unlock" aria-hidden="true"></i> <span class="ng-binding">Activate!</span></button>
                   <a href="<?=SFA_PRO_PURCHASE;?>" target="_blank" title="Purchase Pro License" class="btn btn-md btn-info btn-with-icon" style="margin-left:10px;">
                     <i class="ti-shopping-cart" aria-hidden="true"></i> <span class="ng-binding">Buy License!</span></a>
               </div>

               <div class="col-xs-12 col-md-8 col-md-pull-4 col-sm-7 col-sm-pull-5" ng-class="{'col-md-8 col-md-pull-4 col-sm-7 col-sm-pull-5': licenseResult.userinfo}">

                  <settings-password ng-if="!displayCompact || !appSettings.pluginMode" settings-scanner-hide-valid="true" class="ng-scope ng-isolate-scope">

                  </settings-password>

                  <div class="form-group has-feedback no-margin-bottom ng-scope has-error" ng-class="{'has-error': !licenseResult.valid, 'has-success': licenseResult.valid}" ng-if="ajaxIdLicense.valid">
                     <div class="input-group"><span class="input-group-addon addon-left ng-binding">License Key</span>
                       <input  class="form-control ng-valid ng-not-empty ng-dirty ng-valid-parse ng-touched" autocomplete="off" name="sfa_sn" placeholder="Please enter a License Key" >
                     </div>
                  <label class="control-label"><small class="footnote ng-binding"><b>*</b> License Key is too short (must be at least 10 characters).</small></label>
                  </div>

               </div>
            </div>
            <!-- ngIf: ajaxIdLicense.valid && licenseResult.userinfo.email && (!displayCompact || (licenseResult.type !== 'business' && licenseResult.type !== 'premium')) -->
         </div>
         <!-- end ngIf: dataLoaded -->
         <input type="text" hidden name="sfa_action" value="activate_sn">
      </settings-license>
    </form>
   </div>
</div>
</div>
</div>
<style>
.has-error .form-control {
    border: 1px solid #79c29a !important;
}
.input-group .form-control {
    z-index: auto;
}
.has-error .form-control {
    background-color: #ffffff !important;
    color: #79c29a !important;
}
.has-error .input-group-addon {
    background-color: #56ad7d !important;
    color: #fff;
}
</style>
<? endif; ?>
