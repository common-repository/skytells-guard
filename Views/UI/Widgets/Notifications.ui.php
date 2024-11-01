@php
$SFA_Notifications = \Skytells\SFA\Notifications::fetch();
$nf = count($SFA_Notifications);
@endphp
@if (!empty($SFA_Notifications))

<div class="row" id="quickNotifications">
  <div class="col-lg-12">
    <div class="wf-dashboard-item active">
    	<div class="wf-dashboard-item-inner">
    		<div class="wf-dashboard-item-content">
    			<div class="wf-dashboard-item-title">
    				<strong>Notifications</strong>
    				<span class="wf-dashboard-badge wf-notification-count-container wf-notification-count-value">{{$nf}}</span>
    			</div>
    			<div class="wf-dashboard-item-action">
    				<div class="wf-dashboard-item-action-disclosure"><a href="#" onclick="$('#quickNotifications').hide();"><small>Hide</small></a></div>
    			</div>
    		</div>
    	</div>
    	<div class="wf-dashboard-item-extra">

    		<ul class="wf-dashboard-item-list wf-dashboard-item-list-striped">
          <? $i = 1; ?>
          @foreach($SFA_Notifications as $Notify)
    			<li id="nf-{{$i}}" class="wf-notification @if($Notify->score > 5)wf-notification-danger @else wf-notification-warning @endif">
    				<div class="wf-dashboard-item-list-title alert-dismissible" role="alert">
              {{$Notify->message}} <a href="#"  title="{{$Notify->desc}}" class="tippy"><span class="dashicons dashicons-editor-help skyav-info-toggle help-icon"></span></a>
    				</div>
    				<div class="wf-dashboard-item-list-dismiss">
              <a href="#" onclick="$('#nf-{{$i}}').hide();" class="wf-dismiss-notification" data-dismiss="alert" aria-label="Close" class="close">
    						<i class="fa fa-times-circle" aria-hidden="true" ></i>
    					</a>
    				</div>
    			</li>
          <? $i++; ?>
        @endforeach

    		</ul>
    	</div>
    </div>
  </div>
</div>
@endif
