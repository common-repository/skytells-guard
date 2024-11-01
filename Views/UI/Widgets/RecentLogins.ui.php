<div class="card" style="font-size:13px;">
    <div class="header">
        <h4 class="title">Recent Logins</h4>
        <p class="category">Latest Logins ( <? echo count($Logins);?> ) - <a href="{{admin_url('admin.php?page=skytells-guard&sfa_action=clearloginslog')}}">Clear Log</a></p>
    </div>
    <div class="content">
      <div class="content table-responsive table-full-width">
      @php $Logins = json_decode(json_encode($Logins)) @endphp
      @if ($Logins != false)
          <table class="table datatable border-none" style="font-size:13px;">
              <thead>
                <th style="font-size:13px;">User</th>
                <th style="font-size:13px;">Datetime</th>
                <th style="font-size:13px;">Location</th>
                <th style="font-size:13px;">OS</th>
                <th style="font-size:13px;">IP</th>
                <th style="font-size:13px;">Browser</th>
                <th style="font-size:13px;">Action</th>
              </thead>
              <tbody>
                @foreach ($Logins as $login)
                    <tr style="font-size:13px;">
                      <td><? echo $login->username;?></td>
                      <td><? echo skytells_ago($login->stamp);?></td>
                      <td><? echo $login->city.', '.$login->region_code.', '.$login->country;?></td>
                      <td><? echo $login->os;?></td>
                  
                      <td><a href='#' class='tippy js_ipinfo' data-ip='<? echo $login->ip;?>' data-token='<? echo md5($login->ip);?>' title='Click to Lookip this IP'><? echo $login->ip;?></a></td>
                      <td><? echo $login->browser;?></td>
                      <td><a href="#" onclick="viewLogin(<?= $login->id; ?>, '{{$login->ip}}', '{{md5($login->id.$login->ip)}}');" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a></td>
                    </tr>
                  @endforeach
              </tbody>
          </table>
          <div class="footer">
            <div class="chart-legend">
                <i class="fa fa-circle text-info"></i> Monitoring
                <i class="fa fa-circle text-warning"></i> <? echo count($Logins);?> Logins Detected!
            </div>
            <hr>
            <div class="stats">
                <i class="ti-check"></i> Self-Defence Activated!
            </div>
        </div>
      @else
        <div class="footer">
          <div class="chart-legend">
              <i class="fa fa-circle text-info"></i> Running
              <i class="fa fa-circle text-warning"></i> No Warnings
          </div>
          <hr>
          <div class="stats">
              <i class="ti-check"></i> There is no logins until now!
          </div>
      </div>
    @endif

      </div>
    </div>
</div>

<script>
function viewLogin(id, ip, token) {
  $.post(ajaxurl, { action:'sfa', SFA_AjaxAction: 'getLoginDetails', loginid: id, ip:ip, token: token }, function( data ) {

  $.sweetModal({
    title: 'View Login Details',
    content: data
  });
  });

}
</script>
