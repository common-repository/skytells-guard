<div class="panel xsmall-panel light-text title-ellipsis with-scroll animated zoomIn no-animation" zoom-in="">
   <div class="panel-heading clearfix">
      <h4 class="panel-title"> <i class="ti-search panel-ti"></i> Quick Scan
        <a href="#"  title="You need to scan your website.." data-toggle="tooltip"><span class="dashicons dashicons-editor-help skyav-info-toggle help-icon"></span></a>
      </h4>
   </div>
   <div class="panel-body" ng-transclude="">

              <div class="row">

               <div class="col-md-12">
                  <div scan-statistics="" scan-statistics-complete="moreOptionsToggle" scan-statistics-database="moreOptionsToggle" scan-statistics-level="true" scan-statistics-memory="moreOptionsToggle" scan-statistics-timestamp="true" class="margin-bottom-sm ng-isolate-scope">
                     <ul ng-show="!statisticsData" class="list-unstyled ng-hide">

                        <li class="ng-binding">Just to assure that your website is running clean.</li>
                     </ul>
                     <a href="admin.php?page=sfa-scanner" title="Start Scan" class="btn btn-md btn-success btn-with-icon" >
                       <i class="fa fa-search" aria-hidden="true"></i> <span class="ng-binding">Start Scan</span></a>
                  </div>

                    <small style="padding-top:17px;">
                      You need to scan your website every day!<br>
                      Skytells AV detects unknown viruses. Effective filtering of binary files. Detects viruses in PHP scripts renamed as images. ..etc.
                    </small>

               </div>
            </div>
         </div>
      </div>
