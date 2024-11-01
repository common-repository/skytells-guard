<? $SFA_Notifications = \Skytells\SFA\Notifications::fetch();
$nf = count($SFA_Notifications); ?>

<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="danger">

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="#" class="simple-text" style="text-transform: normal;">
                  <div class="icon-big icon-success text-center" style="text-transform: none;">
                                            <b><i class="ti-shield"></i></b>  Skytells <b>Guard</b>
                                        </div>

                </a>
            </div>

            <ul class="nav">
                <li class="<? if ($_SKYVARS['page'] == 'dashboard'){ echo 'active'; } ?>">
                    <a href="admin.php?page=skytells-guard">
                        <i class="ti-panel"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="<? if ($_SKYVARS['page'] == 'brute-force'){ echo 'active'; } ?>">
                    <a href="admin.php?page=sfa-brute-force">
                        <i class="ti-shield"></i>
                        <p>Brute Force</p>
                    </a>
                </li>
                <li class="<? if ($_SKYVARS['page'] == 'firewall'){ echo 'active'; } ?>">
                    <a href="admin.php?page=sfa-firewall">
                        <i class="ti-eye"></i>
                        <p>Firewall</p>
                    </a>
                </li>

                <li class="<? if ($_SKYVARS['page'] == 'scanner'){ echo 'active'; } ?>">
                    <a href="admin.php?page=sfa-scanner">
                        <i class="ti-search"></i>
                        <p>Anti-Virus</p>
                    </a>
                </li>


                <li class="<? if ($_SKYVARS['page'] == 'metainfo'){ echo 'active'; } ?>">
                    <a href="admin.php?page=sfa-metainfo-protection">
                        <i class="ti-sharethis"></i>
                        <p>MetaTags Protection</p>
                    </a>
                </li>


                <li class="<? if ($_SKYVARS['page'] == 'vulnerabilities'){ echo 'active'; } ?>">
                    <a href="admin.php?page=skyav-exploits">
                        <i class="ti-wand"></i>
                        <p>Exploits Scanner</p>
                    </a>
                </li>

                <li class="<? if ($_SKYVARS['page'] == 'analysis'){ echo 'active'; } ?>">
                    <a href="admin.php?page=sfa-analysis">
                        <i class="ti-pulse"></i>
                        <p>Security Analysis</p>
                    </a>
                </li>

                <li>
                    <a href="admin.php?page=sfa-notifications">
                        <i class="ti-bell"></i>
                        <p>Notifications <span class="badge badge-pill bg-danger" style="text-transform: none;"><?=$nf;?></span></p>
                    </a>
                </li>


                <li class="<? if ($_SKYVARS['page'] == 'settings'){ echo 'active'; } ?>">
                    <a href="admin.php?page=sfa-settings">
                        <i class="ti-settings"></i>
                        <p>Settings</p>
                    </a>
                </li>

				<li class="<? if ($_SKYVARS['page'] == 'pro'){ echo 'active'; } ?>">
                    <a href="admin.php?page=skyav-pro">
                        <i class="ti-export"></i>
                        <p>Upgrade to <span class="badge badge-pill bg-warning" style="    background: #f5a500;
    text-transform: none;">Pro</span></p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="#"><?=$_SKYVARS['title']; ?></a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="ti-panel"></i>
								<p>Stats</p>
                            </a>
                        </li>
                        <li class="dropdown">
                              <a href="admin.php?page=sfa-notifications" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="ti-bell"></i>
                                    <p class="notification"><?=$nf;?></p>
									<p>Notifications</p>
									<b class="caret"></b>
                              </a>
                              <ul class="dropdown-menu">
                                <? if (!empty($SFA_Notifications)) : ?>
                                <? foreach($SFA_Notifications as $Notify): ?>
                                <li><a href="<?=$Notify->url;?>"><?=$Notify->message;?></a></li>
                              <? endforeach; ?>
                            <? else: ?>
                            <li><a href="#">No Notifications!</a></li>
                            <? endif; ?>
                              </ul>
                        </li>
						<li>
                            <a href="#">
								<i class="ti-settings"></i>
								<p>Settings</p>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
