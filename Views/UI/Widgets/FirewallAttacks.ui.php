<div class="card" style="font-size:13px;">
    <div class="header">
        <h4 class="title">Firewall Statistics</h4>
        <p class="category">Latest Attacks ( <? echo count($Attacks);?> ) - <a href="{{admin_url('admin.php?page=skytells-guard&sfa_action=clearattackslog')}}">Clear Log</a></p>
    </div>
    <div class="content">
      <div class="content table-responsive table-full-width">
      <?
      if ($Attacks != false):
        ?>

          <table class="table  datatable border-none" style="font-size:13px;">
              <thead>
                <th style="font-size:13px;">ID</th>
                <th style="font-size:13px;">Datetime</th>
                <th style="font-size:13px;">Origin</th>
                <th style="font-size:13px;">OS</th>
                <th style="font-size:13px;">IP</th>
                <th class="retina-only" style="font-size:13px;">Browser</th>
                <th class="retina-only" style="font-size:13px;">Method</th>
                <th style="font-size:13px;">Action</th>
              </thead>
              <tbody>
                  <?

                    foreach ($Attacks as $attack):

                    ?>
                    <tr style="font-size:13px;">
                      <td><? echo $attack->id;?></td>
                      <td><? echo skytells_ago($attack->stamp);?></td>
                      <td><? echo $attack->country;?></td>
                      <td><? echo $attack->os;?></td>

                      <td><a href='#' class='tippy js_ipinfo' data-ip='<? echo $attack->ip;?>' data-token='<? echo md5($attack->ip);?>' title='Click to Lookip this IP'><? echo $attack->ip;?></a></td>
                      <td class="retina-only"><? echo $attack->browser;?></td>

                      <td class="retina-only"><? echo $attack->method;?></td>
                      <td><a href="#" title="View Details" onclick="viewAttack(<?= $attack->id; ?>, '{{$attack->ip}}', '{{md5($attack->id.$attack->ip)}}');" class="btn btn-xs btn-info tippy"><i class="fa fa-eye"></i></a></td>
                    </tr>
                    <?
                  endforeach;
              ?>

              </tbody>
          </table>
          <div class="footer">
            <div class="chart-legend">
                <i class="fa fa-circle text-info"></i> Running
                <i class="fa fa-circle text-warning"></i> <? echo count($Attacks);?> Attacks Detected!
            </div>
            <hr>
            <div class="stats">
                <i class="ti-check"></i> Self-Defence Activated!
            </div>
        </div>
          <?
        else:
        ?>
        <div class="footer">
          <div class="chart-legend">
              <i class="fa fa-circle text-info"></i> Running
              <i class="fa fa-circle text-warning"></i> No Warnings
          </div>
          <hr>
          <div class="stats">
              <i class="ti-check"></i> There is no attacks until now!
          </div>
      </div>
        <?
        endif;
            ?>

      </div>
    </div>
</div>

<script>
function viewAttack(id, ip, token) {
  $.post(ajaxurl, { action:'sfa', SFA_AjaxAction: 'getAttack', attid: id, ip:ip, token: token }, function( data ) {

  $.sweetModal({
    title: 'View Attack Log',
    content: data
  });
  });

}
</script>
