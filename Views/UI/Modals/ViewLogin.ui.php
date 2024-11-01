@if (isset($login))
<? $login = SFA_toObject($login);
$location = $login->city.', '.$login->region_code.', '.$login->country;
?>
<div style="font-size:12px;">
<p>This Login detected at {{$login->stamp or ''}}</p>

		<div class="row">
			<div class="col-md-6">
				<p>
					<strong>Login Information</strong>
				</p>
				<p>User : {{$login->username or ''}}

					<br>IP Address :{{$login->ip}}
					<br/>Location :{{$location or ''}}
					<br/>Browser :{{$login->browser}}
					<br/>Operating System : {{$login->os}}
					<br/>Status : {{$login->status}}

				</p>
			</div>

		</div>

<hr>
<iframe width="100%" src="https://v.skytells.net/LocatePoint.php?location={{$login->geo or '10.00,22.00'}}&width=100%" style="border:none;" noscrolling></iframe>
</div>
@endif
