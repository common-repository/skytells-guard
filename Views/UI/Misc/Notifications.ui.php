@php $nf = count($SFA_Notifications); @endphp
@include('Layouts.Header', ['title' => 'Skytells Notifications ('.$nf.')', 'page' => 'notifications'])

<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-sm-12">
				<div class="card">
					<div class="content">
						<h5>You have
							<?=$nf?> Security Notifications!
						</h5>
						<hr>
            @if (!empty($SFA_Notifications))
              @foreach($SFA_Notifications as $Notify)

							<div class="row">
								<div class="col-xs-12">
									<div class="alert
										<?if ($Notify->score > 5){ echo "alert-danger"; }else{echo "alert-warning";} ?>">
										<button type="button" aria-hidden="true" class="close">×</button>
										<strong>
											<b class="
												<?if ($Notify->score > 5){ echo "twhite"; }?>">
												<?=$Notify->message;?>
											</b>
										</strong>
										<span>
											<b class="
												<?if ($Notify->score > 5){ echo "twhite"; }?>"> Warning -
											</b>
											<?=$Notify->desc;?>
										</span>
										<span style="padding-top:4px;">
											<b>
												<a class="
													<?if ($Notify->score > 5){ echo "twhite"; }?>" href="
													<?=$Notify->url;?>" target="_blank">Fix it
												</a>
											</b>
										</span>
									</div>
								</div>
							</div>
            @endforeach
          @else

							<p>You do not have any notifications</p>
          @endif

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@include('Layouts.Footer')
