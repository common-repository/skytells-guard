@if (!Skytells\SFA::CL())
  <div class="row">
    <div class="col-xs-12">
      <div class="alert alert-warning">
        <button type="button" aria-hidden="true" class="close">×</button>
        <strong><b>Limited Access (Disabled Feature)</b></strong>
          <span><b> Warning - </b> You're currently running on a FREE license while The IP Lookup needs a Pro license to perform its own functions.</span>
          <span>Please keep in mind that IPLookup will not perform it's functionality on the FREE version.</span>
          <span style="padding-top:4px;"><b><a href="<?=SFA_PRO_PURCHASE;?>" target="_blank">Click Here to Purchase A Pro License</a></b></span>

        </div>
    </div>
  </div>
@else
@if (isset($data))
<? $data = SFA_toObject($data);
$location = $data->latitude.','.$data->longitude;
?>
<div style="font-size:12px;">
<p>This IP associated to {{$data->country_name or ''}}</p>

		<div class="row">
			<div class="col-md-6">
				<p>
					<strong>IP Information</strong>
				</p>
				  <p>Country : {{$data->country_name or ''}} ({{$data->country_code}})
					<br/>State : {{$data->region or ''}} ({{$data->region_code or ''}})
					<br/>City : {{$data->city or ''}}
          <br/>Zipcode : {{$data->zip_code or 'Unknown'}}
				</p>
			</div>
			<div class="col-md-6">
				<p>
					<strong>Other Information</strong>
				</p>
				   <p>IP Address :{{$data->ip}}
          <br/>Latitude : {{$data->latitude or ''}}
   				<br/>Longitude : {{$data->longitude or ''}}
					<br/>Timezone : {{$data->time_zone or ''}}

				</p>
			</div>

		</div>

<hr>
<iframe width="100%" src="https://v.skytells.net/LocatePoint.php?location={{$data->geo or '10.00,22.00'}}&width=100%" style="border:none;" noscrolling></iframe>
</div>
@endif
@endif
