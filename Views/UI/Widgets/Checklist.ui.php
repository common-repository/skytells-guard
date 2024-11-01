
<div class="row">
  <div class="col-xs-12">
    <? if ((bool)get_option('SFA_firewall') !== true): ?>
    <div class="alert alert-warning alert-dismissible" role="alert" >
      <button type="button" aria-hidden="true" data-dismiss="alert" aria-label="Close" class="close">×</button>
        <span><b> Warning - </b> The Firewall is currently disabled, Please Enable the Firewall to protect your website from attacks.</span>
      </div>
    <? endif; ?>


    <? if ((bool)get_option('SFA_bruteforce') !== true): ?>
    <div class="alert alert-warning alert-dismissible" role="alert" >
      <button type="button" aria-hidden="true" aria-label="Close" data-dismiss="alert" class="close">×</button>
        <span><b> Warning - </b> The Brute Force Protection module is currently disabled, Please enable it to protect your website from global attacks</span>
      </div>
    <? endif; ?>
  </div>
</div>
