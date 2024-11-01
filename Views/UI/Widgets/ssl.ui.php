<div class="panel xsmall-panel light-text title-ellipsis with-scroll animated zoomIn no-animation" zoom-in="">
   <div class="panel-heading clearfix">
      <h4 class="panel-title">Blacklist Monitoring</h4>
   </div>
   <div class="panel-body" ng-transclude="">

      <div ng-include="'app/pages/dashboard/dashboardScanSummary/widgets/resultsBlacklist.html'" class="ng-scope">

         <div ng-if="blDataLoaded" class="ng-scope" style="">

            <div class="row" ng-if="resultsBlacklist">
               <div class="col-md-2">

                  <div class="text-danger ng-scope" ng-if="resultsBlacklist.warning"><i class="fa fa-45x fa-exclamation-circle" aria-hidden="true" title="Site Potentially Harmful"></i></div>

               </div>
               <div class="col-md-10">
                  <ul class="list-unstyled">
                     <li><small><b class="ng-binding">Website:</b></small> <span ng-class="resultsBlacklist.warning ? 'text-danger' : 'text-success'" class="ng-binding text-danger">localhost</span></li>

                     <li ng-if="resultsBlacklist.warning" class="ng-scope"><small><b class="ng-binding">Web Trust:</b></small> <span class="text-danger ng-binding">Blacklisted / Blocked. <b class="footnote">*</b></span></li>
                     <li ng-if="!resultsBlacklist.site.ssl.enabled" class="ng-scope"><small><b class="ng-binding">SSL Certificate:</b></small> <span class="text-warning ng-binding">Disabled</span> <a class="btn btn-xs btn-warning btn-with-icon" role="button" title="Get SSL Certificate" target="_top" href="https://clients.cobweb-security.com/cart.php?a=add&amp;pid=5&amp;carttpl=modern"><i class="fa fa-lock" aria-hidden="true"></i><b class="ng-binding">Fix It</b></a></li>
                  </ul>
               </div>
            </div>
            <small ng-if="resultsBlacklist" class="footnote ng-binding ng-scope">
               <b>*</b> Domain blacklist check tool. <!-- ngIf: resultsBlacklist --><span ng-if="resultsBlacklist" class="ng-binding ng-scope">Cached results from 2018-02-11 03:22</span><!-- end ngIf: resultsBlacklist -->
            </small>
         </div>
         <button type="button" class="btn btn-xs btn-with-icon btn-position-bottom-right no-transform ng-binding ng-scope" ng-click="location.goSiteCheckResults()"><i class="fa fa-angle-right" aria-hidden="true"></i>Open a detailed report</button>
      </div>
   </div>
</div>
