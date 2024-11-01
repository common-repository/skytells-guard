<? $nf = count($SFA_Notifications); ?>
<? layout_import('header', array("title" => 'Skytells Notifications ('.$nf.')', 'page' => 'notifications')); ?>
  <div class="content">
    <h5>You have <?=$nf?> Security Notifications!</h5>
    <hr>
    <? if (!empty($SFA_Notifications)) : ?>
    <? foreach($SFA_Notifications as $Notify): ?>
    <div class="row">
      <div class="col-xs-12">

        <div class="alert <?if ($Notify->score > 5){ echo "alert-danger"; }else{echo "alert-warning";} ?>">
          <button type="button" aria-hidden="true" class="close">×</button>
          <strong><b class="<?if ($Notify->score > 5){ echo "twhite"; }?>"><?=$Notify->message;?></b></strong>
            <span><b class="<?if ($Notify->score > 5){ echo "twhite"; }?>"> Warning - </b> <?=$Notify->desc;?></span>

            <span style="padding-top:4px;"><b><a class="<?if ($Notify->score > 5){ echo "twhite"; }?>" href="<?=$Notify->url;?>" target="_blank">Fix it</a></b></span>

          </div>
      </div>
    </div>
    <? endforeach; ?>
  <? else: ?>
  <p>You do not have any notifications</p>
<? endif; ?>
</div>



<? layout_import('footer'); ?>
