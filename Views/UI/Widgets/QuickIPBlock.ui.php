<div class="panel xsmall-panel light-text title-ellipsis with-scroll animated zoomIn no-animation" zoom-in="">
   <div class="panel-heading clearfix">
      <h4 class="panel-title"> <i class="ti-target panel-ti"></i> Permanently Blocked IPs
        <a href="#"  title="Permanently Blocked IPs means a LIST of an IP addresses which Permanently BLOCKED from accessing the whole website!, This Option requires Firewall to be ON" data-toggle="tooltip"><span class="dashicons dashicons-editor-help skyav-info-toggle help-icon"></span></a>
      </h4>
   </div>
   <div class="panel-body" ng-transclude="">


          <div class="row" >
            <div class="col-xs-12">

              @include('Widgets.Feeds.BlockedIPS', ['required' => 'required'])
          <small style="padding-bottom:8px;">* This Feature Requires Firewall to be ON.</small>

            </div>


      </div>
   </div>
</div>
