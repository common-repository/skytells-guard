<table class="widefat fixed " style="border:none; margin-bottom:4px;">
    <thead>
        <tr>
            <th width="20%">CF</th>
            <th width="50%">IP Address</th>
            <th width="30%">Action</th>
        </tr>
    </thead>

  <tbody>

@php
$blockedIPS = (isset($blockedIPS) && is_array($blockedIPS)) ? $blockedIPS : \Skytells\SFA\IP::getRecentBans(25);
$blockedIPS = SFA_toObject($blockedIPS);
   if ($blockedIPS != false) {
     $i = 0;
    foreach ($blockedIPS as $IP) {
      if (!empty($IP)) {
        $i++;

      $cf = ((bool)$IP->cfbanned == true) ? '<o class="badge bg-success tippy" title="This IP is also Banned at CloudFlare"><i class="fa fa-cloud"></i></o>' : '<o class="badge bg-info tippy" title="This IP is banned locally and not Banned at CloudFlare"><i class="fa fa-cloud"></i></o>';
      echo '<tr>';
      echo "<td>$cf</td>";
      echo "<td><a href='#' class='tippy js_ipinfo' data-ip='{$IP->ip}' data-token='".md5($IP->ip)."' title='Click to Lookip this IP'>{$IP->ip}</a></td>";
      echo "<td><form id='ipub-$i' method='post' action=''>
       <input hidden name='firewall_action' value='unblockip'>
       <input hidden name='IP' value='{$IP->ip}'>
       <input hidden name='cid' value='{$IP->banid}'>
       <a href='#' class='btn btn-xs btn-success js_unblockip' data-form='ipub-$i'>Unblock</a>
       </form></td>";
         echo '</tr>';
      }
    }
  }
  echo '<form id="fblockip" method="post" action="">';
  echo '<tr>';
  echo "<td>Block IP</td>";
  echo '<td>  <input type="text" name="IP" id="bipAddr" class="" placeholder="IP to block.." '.$required.' /></td>';
  echo '<td><a href="#" name="blacklisted" class="btn btn-sm btn-danger js_blockip" data-form="fblockip">Block</a></td>';
     echo '</tr>';
     echo '<input name="firewall_action" value="blockip" hidden>
  </form>';
@endphp

</tbody>
</table>
