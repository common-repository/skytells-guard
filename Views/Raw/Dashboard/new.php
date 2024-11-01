<? layout_import('header', array("title" => 'Dashboard', 'page' => 'dashboard')); ?>


<?
$Attacks = Skytells_Firewall::getSQLAttacks();
$blockedIPS = Skytells_Firewall::getBlockedIPS();
?>
        <div class="content">

            <div class="container-fluid">
                <div class="row">
                  <div class="col-lg-12">
                  <? layout_import('nav'); ?>
                </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-warning text-center">
                                            <i class="ti-shield"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Protected Attacks</p>
                                            <? echo count($Attacks); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-eye"></i> Firewall
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-success text-center">
                                            <i class="ti-wallet"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>License</p>
                                            <? if (\Skytells\SFA::CL()) : ?>
                                            PRO
                                          <? else: ?>
                                          FREE
                                        <? endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-calendar"></i> <a href="admin.php?page=skyav-pro">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-danger text-center">
                                            <i class="ti-pulse"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Blocked IP(s)</p>
                                            <? if ($blockedIPS != false) { count($blockedIPS); } else { echo "0"; } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-timer"></i> In the last hour
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-info text-center">
                                            <i class="ti-unlock"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="">
                                            <p>Security Analysis</p>
                                            <? if (\Skytells\SFA::CL()) : ?>
                                            PRO
                                          <? else: ?>
                                          BASIC <small style="font-size:12px;">(Pro) Needed</small>
                                        <? endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-reload"></i> <a href="admin.php?page=sfa-analysis">Analyze</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <? sfa_view('Widgets.Checklist'); ?>
                <? sfa_view('Widgets.Activate'); ?>
                <div class="row">

                    <div class="col-xs-4">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Brute Force</h4>
                                  <p class="category">Module Status: <o style="color:#2bcd70">Active</o></p>
                            </div>
                            <div class="content">
                               <img class="card-img-top" style="width:100%; max-height:230px; padding-bottom:12px;" src="<?=getSFAURL();?>/assets/images/bruteficon.jpg" alt="Brute Force">

                               <div class="card-body">
                                 <p class="card-text" style="font-size:13px;">Skytells Brute Force is a lightweight plugin that protects your website against brute force login attacks.</p>
                                 <a href="admin.php?page=sfa-brute-force" class="btn btn-info">Module Settings</a>
                               </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xs-4">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Firewall</h4>
                                  <p class="category">Module Status: <o style="color:#2bcd70">Active</o></p>
                            </div>
                            <div class="content">
                               <img class="card-img-top" style="width:100%; max-height:230px; padding-bottom:12px;" src="<?=getSFAURL();?>/assets/images/firewall-icon.png" alt="Brute Force">

                               <div class="card-body">
                                 <p class="card-text" style="font-size:13px;">Skytells Firewall prevents SQL Injection, DDoS Attacks and most types of attacks.</p>
                                 <a href="admin.php?page=sfa-firewall" class="btn btn-info">Module Settings</a>
                               </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xs-4">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Face ID</h4>
                                <p class="category">Module Status: <o style="color:#d86969">Disabled</o></p>
                            </div>
                            <div class="content">
                               <img class="card-img-top" style="width:100%; max-height:230px; padding-bottom:12px;" src="<?=getSFAURL();?>/assets/images/faceid.jpg" alt="FaceID">

                               <div class="card-body">
                                 <p class="card-text" style="font-size:13px;">Skytells FaceID is a powerful tool to protect your WordPress with your own Face.</p>
                                 <a href="admin.php?page=sfa-firewall" class="btn btn-info">Go Pro</a>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-4">
                      <?sfa_view('Widgets.SSLCheck');?>
                    </div>
                    <div class="col-xs-4">
                      <?sfa_view('Widgets.QuickIPBlock');?>
                    </div>
                    <div class="col-xs-4">
                      <?sfa_view('Widgets.quick-scan');?>
                    </div>
                    <div class="col-xs-12">

                        <div class="card" style="font-size:13px;">
                            <div class="header">
                                <h4 class="title">Firewall Statistics</h4>
                                <p class="category">Latest Attacks ( <? echo count($Attacks);?> )</p>
                            </div>
                            <div class="content">
                              <div class="content table-responsive table-full-width">
                              <?
                              if ($Attacks != false):
                                ?>

                                  <table class="table table-striped" style="font-size:13px;">
                                      <thead>
                                        <th style="font-size:13px;">Datetime</th>
                                        <th style="font-size:13px;">OS</th>
                                        <th style="font-size:13px;">IP</th>
                                        <th style="font-size:13px;">Browser</th>
                                        <th style="font-size:13px;">Query</th>
                                      </thead>
                                      <tbody>
                                          <?

                                            foreach ($Attacks as $attack):

                                            ?>
                                            <tr style="font-size:13px;">
                                              <td><? echo skytells_ago($attack->datetime);?></td>
                                              <td><? echo $attack->os;?></td>
                                                <td><? echo $attack->ip;?></td>
                                            <td><? echo $attack->browser;?></td>
                                            <td><? echo $attack->query;?></td>
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
                    </div>



                </div>
            </div>
        </div>
<? layout_import('footer'); ?>
