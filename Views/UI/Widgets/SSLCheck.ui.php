<div class="panel xsmall-panel light-text title-ellipsis with-scroll animated zoomIn no-animation" zoom-in="">
   <div class="panel-heading clearfix">
      <h4 class="panel-title">Secure Protocol</h4>
   </div>
   <div class="panel-body" ng-transclude="">

      <div class="ng-scope">
          <div class="row" >
         <div ng-if="blDataLoaded" class="ng-scope" style="">


               <div class="col-xs-3">
                 <? if (Skytells\Controllers\HTTP::isSSL() === true): ?>
                  <div class="text-success ng-scope" ng-if="resultsBlacklist.warning">
                    <i class="fa fa-45x fa-check" aria-hidden="true" title="Site Secured"></i>
                  </div>
                <? else: ?>
                <div class="text-danger ng-scope" ng-if="resultsBlacklist.warning">
                  <i class="fa fa-45x fa-exclamation-circle" aria-hidden="true" title="Site Potentially Harmful"></i>
                </div>
                <? endif; ?>
               </div>
               <div class="col-xs-9">
                 <br>
                  <ul class="list-unstyled">
                     <li>
                       <small><b class="ng-binding">Website:</b></small>
                       <span class="ng-binding text-<?$x = (Skytells\Controllers\HTTP::isSSL() === true) ? 'success':'danger'; echo $x; ?>"><?= Skytells\SFA\Foundation::getCurrentDomain(); ?></span>
                     </li>


                     <li ng-if="!resultsBlacklist.site.ssl.enabled" class="ng-scope"><small><b class="ng-binding">SSL Certificate:</b>
                        <? if (Skytells\Controllers\HTTP::isSSL() === false): ?>
                     </small>
                     <span class="text-warning ng-binding">Disabled</span>
                     <a class="btn btn-xs btn-warning btn-with-icon" role="button" title="Get SSL Certificate" target="_top" href="https://www.skytells.org/ssl-certificates"><i class="fa fa-lock" aria-hidden="true"></i>
                       <b class="ng-binding">Fix It</b></a>
                       <? else: ?>
                       <span class="text-success ng-binding">Active</span>
                       <? endif; ?>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="col-xs-12">
              <small ng-if="resultsBlacklist" class="footnote ng-binding ng-scope">
                 <b>*</b> SSL Certificate is important for your WordPress.<br>
                 <span ng-if="resultsBlacklist" class="ng-binding ng-scope">Most Search engines trusts Secure-Websites only.</span>

              </small>
            </div>
         </div>
      </div>
   </div>
</div>
