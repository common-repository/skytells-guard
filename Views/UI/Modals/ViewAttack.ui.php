@if (isset($attack))
<? $attack = SFA_toObject($attack);
$location = $attack->city.', '.$attack->region_code.', '.$attack->country;
?>
<div style="font-size:12px;">
<p>This Attack detected at {{$attack->stamp or ''}}</p>
<p>
	<strong>URL</strong>
</p>

		<pre >{{$attack->url or ''}}</pre><br>
		<div class="row">
			<div class="col-md-6">
				<p>
					<strong>Attack Information</strong>
				</p>
				<p>Attack Type : {{$attack->type or ''}}
					<br/>Datetime : {{$attack->stamp or ''}}
					<br/>Method : {{$attack->method or ''}}
					<br/>Query String : {{$attack->querystring or ''}}
					<br/>Referer : {{$attack->referer or 'SELF'}}

				</p>
			</div>
			<div class="col-md-6">

				<p>
					<strong>Attacker's Information</strong>
				</p>
				<p>IP Address :{{$attack->ip}}
					<br/>Location :{{$location or ''}}
					<br/>Browser :{{$attack->browser}}
					<br/>Operating System : {{$attack->os}}
					<br/>Geographic L&L : {{$attack->geo}}

				</p>
			</div>

		</div>

<hr>
<iframe width="100%" src="https://v.skytells.net/LocatePoint.php?location={{$attack->geo or '10.00,22.00'}}&width=100%" style="border:none;" noscrolling></iframe>
</div>
@endif
