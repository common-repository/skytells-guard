<? if ((!\Skytells\SFA::CL())) : ?>
<div class="row">
  <div class="col-xs-12">
    <div class="alert alert-warning">
      <button type="button" aria-hidden="true" class="close">×</button>
      <strong><b>Limited Access (Disabled Feature)</b></strong>
        <span><b> Warning - </b> You're currently running on a FREE license while The <?=$SFA_ALERT['feature'];?> needs a Pro license to perform its own functions.</span>
        <span>Please keep in mind that <?=$SFA_ALERT['feature'];?> will not perform it's functionality on the FREE version.</span>
        <span style="padding-top:4px;"><b><a href="<?=SFA_PRO_PURCHASE;?>" target="_blank">Click Here to Purchase A Pro License</a></b></span>

      </div>
  </div>
</div>
<? endif; ?>
