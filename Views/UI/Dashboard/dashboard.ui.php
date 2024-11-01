@include('Layouts.Header', ['title' => 'Skytells Guard Dashboard', 'page' => 'dashboard'])
<?
$Attacks = Skytells\SFA\Activities::getRecentAttacks();
$AttacksNum = Skytells\SFA\Activities::getAttacksSum();
$Attacks = (is_array($Attacks)) ? SFA_toObject($Attacks) : $Attacks;
$blockedIPS = Skytells_Firewall::getBlockedIPS();
$BansSum = Skytells\SFA\IP::getBansSum();
?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card auto-min-width">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="icon-big icon-warning text-center">
                                            <i class="ti-shield"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-8">
                                        <div class="numbers">
                                            <p>Protected Attacks</p>
                                            {{$AttacksNum}}
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
                        <div class="card auto-min-width">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="icon-big icon-success text-center">
                                            <i class="ti-wallet"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-8">
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
                        <div class="card auto-min-width">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="icon-big icon-danger text-center">
                                            <i class="ti-pulse"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-8">
                                        <div class="numbers">
                                            <p>Blocked IP(s)</p>
                                            {{$BansSum}}
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
                        <div class="card auto-min-width">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="icon-big icon-info text-center">
                                            <i class="ti-unlock"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-8">

                                            <p>Security Analysis</p>
                                            <? if (\Skytells\SFA::CL()) : ?>
                                            PRO
                                          <? else: ?>
                                          BASIC <small style="font-size:12px;">(Pro) Needed</small>
                                        <? endif; ?>

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

                @include('Widgets.Notifications')

                @include('Widgets.Checklist')
                @include('Widgets.Activate')
                <div class="row">


                    <div class="col-xs-4">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Brute Force</h4>
                                  <p class="category">Module Status: @if(get_option('SFA_bruteforce'))<o style="color:#2bcd70">Active</o>@else <o style="color:#d86969">Disabled</o>@endif</p>
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
                                  <p class="category">Module Status: @if(get_option('SFA_firewall'))<o style="color:#2bcd70">Active</o>@else <o style="color:#d86969">Disabled</o>@endif</p>
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
                                <p class="category">Module Status: @if(get_option('SFA_FaceID'))<o style="color:#2bcd70">Active</o>@else <o style="color:#d86969">Disabled</o>@endif</p>
                            </div>
                            <div class="content">
                               <img class="card-img-top" style="width:100%; max-height:230px; padding-bottom:12px;" src="<?=getSFAURL();?>/assets/images/faceid.jpg" alt="FaceID">

                               <div class="card-body">
                                 <p class="card-text" style="font-size:13px;">Skytells FaceID is a powerful tool to protect your WordPress with your own Face.</p>
                                 <a href="admin.php?page=sfa-faceid" class="btn btn-info">Go Pro</a>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-xs-4">
                      @include('Widgets.SSLCheck')
                    </div>
                    <div class="col-xs-4">
                      @include('Widgets.QuickIPBlock', ['blockedIPS' => $blockedIPS])
                    </div>
                    <div class="col-xs-4">
                      @include('Widgets.quick-scan')
                    </div>
                    <div class="col-xs-8">
                      @include('Widgets.FirewallAttacks', ['Attacks' => $Attacks])
                    </div>

                    <div class="col-xs-4">
                      @include('Widgets.FirewallHighRiskCountries', ['Attacks' => $Attacks])
                    </div>


                    <div class="col-xs-12">
                      @include('Widgets.RecentLogins', ['Logins' => Skytells\SFA\Activities::getRecentLogins(25)])
                    </div>





                </div>
            </div>
        </div>

        @include('Layouts.Footer')
        @include('Widgets.ModalSubscribe')
