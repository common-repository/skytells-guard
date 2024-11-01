@if (isset($_REQUEST['license']) && $_REQUEST['license'] == 'activated')
<div class="row">
  <div class="col-xs-12">
    <div class="alert alert-success">
      <button type="button" aria-hidden="true" class="close">×</button>
      <strong><b>License Activated</b></strong>
        <span>Your Pro License has been successfully activated!</span>
      </div>
  </div>
</div>
@elseif (\Skytells\SFA::A0() && \Skytells\SFA\Dashboard::getCurrentScreen() == 'skyav-pro')
<div class="row">
  <div class="col-xs-12">
    <div class="alert alert-success">
      <button type="button" aria-hidden="true" class="close">×</button>
      <strong><b>License Activated</b></strong>
        <span>Your Pro License is Active!</span>
      </div>
  </div>
</div>
@else
@endif
