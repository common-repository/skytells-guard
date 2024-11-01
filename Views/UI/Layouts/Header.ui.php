@php
$SFA_Notifications = \Skytells\SFA\Notifications::fetch();
$nf = count($SFA_Notifications);
@endphp




<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="info">
		<sfanav>
			<div class="nav-logo-wrapper">
				<a href="{{ admin_url('admin.php?page=skytells-guard') }}">
					<img src="{{SKYTELLS_ASSETS}}/images/logo.svg" title="Skytells Guard">
					</a>
				</div>
				<div class="sfa-nav-menu">
					<div>
						<ul>

							<li class="@if ($page == 'dashboard') active @endif">
								<a title="Dashboard" class="tippy"  href="{{ admin_url('admin.php?page=skytells-guard') }}">
									<span class="sli sli-home menu-icon"></span>
									<span class="label">Dashboard</span>

								</a>
							</li>

							<li class="retina-only @if ($page == 'notifications') active @endif">
								<a title="Notifications" class="tippy"  href="{{ admin_url('admin.php?page=sfa-notifications') }}">
									<span class="sli sli-flag menu-icon"></span>
									<span class="label">Notifications</span>
								</a>
							</li>

              <li class="@if ($page == 'reports') active @endif">
								<a title="Reports" class="tippy"  href="{{ admin_url('admin.php?page=sfa-reports') }}">
									<span class="sli sli-chart menu-icon"></span>
									<span class="label">Reports</span>
								</a>
							</li>
						</ul>
						<ul>
							<li class="@if ($page == 'firewall') active @endif">
								<a title="Firewall" class="tippy"  href="{{ admin_url('admin.php?page=sfa-firewall') }}">
									<span class="special-menu-icon" style="background-color: #EB4B92; background: linear-gradient(134.72deg, #EB4B92 0%, #CA76E3 100%); color: #fff; font-size: 18px;">
                    <span class="mdi mdi-shield"></span>            </span>
									<span class="label">Firewall</span>

								</a>
							</li>
							<li class="@if ($page == 'brute-force') active @endif">
								<a title="Brute Force Protection" class="tippy"  href="{{ admin_url('admin.php?page=sfa-brute-force') }}">
									<span class="special-menu-icon" style="background-color: #00DBDE; background: linear-gradient(136.03deg, #00DBDE 0%, #FC00FF 100%); color: #fff; font-size: 18px;">
              <span class="mdi mdi-eye"></span> </span>
									<span class="label">Brute Force</span>
								</a>
							</li>
							<li class="@if ($page == 'scanner') active @endif">
								<a title="AV Scanner" class="tippy"  href="{{ admin_url('admin.php?page=sfa-scanner') }}">
									<span class="special-menu-icon" style="background-color: #FD646B; background: linear-gradient(-135deg, #FD646B 0%, #FFD102 100%); color: #fff; font-size: 18px;">
										<span class="mdi mdi-magnify"></span>
									</span>
									<span class="label">AI Scanner</span>
								</a>
							</li>
							<li class="@if ($page == 'metainfo') active @endif">
								<a title="Meta Tags Protection" class="tippy" href="{{admin_url('admin.php?page=sfa-metainfo-protection')}}">
									<span class="special-menu-icon" style="background-color: #A077FF; background: linear-gradient(-135deg, #A077FF 0%, #02CDFF 100%); color: #fff; font-size: 18px;">
										<span class="mdi mdi-code-not-equal-variant"></span>
									</span>
									<span class="label">Meta Tags Protection</span>
								</a>
							</li>
							<li class="@if ($page == 'vulnerabilities') active @endif">
								<a title="Exploits Detector" class="tippy" href="{{admin_url('admin.php?page=skyav-exploits')}}">
									<span class="special-menu-icon" style="background-color: #3BE8B0; background: linear-gradient(-135deg, #3BE8B0 0%, #02CDFF 100%); color: #fff; font-size: 18px;">
										<span class="mdi mdi-crosshairs"></span>
									</span>
									<span class="label">Exploits Detector</span>
								</a>
							</li>
							<li class="@if ($page == 'analysis') active @endif">
								<a title="Security Analysis" class="tippy" href="{{admin_url('admin.php?page=sfa-analysis')}}">
									<span class="special-menu-icon" style="background-color: #00E3AE; background: linear-gradient(45deg, #00E3AE 0%, #9BE15D 100%); color: #fff; font-size: 18px;">
										<span class="mdi mdi-server-security"></span>
									</span>
									<span class="label">Security Analysis</span>
								</a>
							</li>


              <li class="retina-only @if ($page == 'faceid') active @endif">
								<a title="Face ID" class="tippy" href="{{admin_url('admin.php?page=sfa-faceid')}}">
									<span class="special-menu-icon" style="background-color: #d556f8; background: linear-gradient(48deg, #eb8cfd 0%, #11d2f2 100%); color: #fff; font-size: 18px;">
										<span class="mdi mdi-fingerprint"></span>
									</span>
									<span class="label">Face ID</span>
								</a>
							</li>
						</ul>
						<ul>


							<li class="@if ($page == 'pro') active @endif">
								<a href="admin.php?page=skyav-pro" title="License & Pro" class="tippy">
                  <span class="badge badge-pill bg-warning" style=" background: #f5a500; text-transform: none;">Pro</span>
									<span class="sli sli-present menu-icon"></span>
									<span class="label">License & Pro</span>
								</a>
							</li>


							<li class="retina-only">
								<a class="tippy" title="Get Managed WordPress Hosting" href="https://www.skytells.org/managed-wordpress-hosting?source=skytells-guard-menu" target="_blank">
									<span class="sli sli-layers menu-icon"></span>
									<span class="label">Get Host</span>
									<span class="tooltip tippy js-tooltip-ready" data-position="right" data-delay="100" data-arrow="true" data-distance="-1" data-tooltipped="" aria-describedby="tippy-tooltip-14" data-original-title="Users"></span>
								</a>
							</li>
							<li class="@if ($page == 'settings') active @endif">
								<a title="Settings" class="tippy" href="{{admin_url('admin.php?page=sfa-settings')}}">
									<span class="sli sli-settings menu-icon"></span>
									<span class="label">Settings</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</sfanav>


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
						<a class="navbar-brand" href="#">
							{{ $title }}
						</a>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							<li>
								<a href="{{admin_url('admin.php?page=sfa-reports')}}" class="dropdown-toggle" data-toggle="dropdown">
									<i class="ti-panel"></i>
									<p>Reports</p>
								</a>
							</li>
							<li class="dropdown">
								<a href="admin.php?page=sfa-notifications" class="dropdown-toggle" data-toggle="dropdown">
									<i class="ti-bell"></i>
									<p class="notification">
										<?=$nf;?>
									</p>
									<p>Notifications</p>
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<? if (!empty($SFA_Notifications)) : ?>
									<? foreach($SFA_Notifications as $Notify): ?>
									<li>
										<a href="
											<?=$Notify->url;?>">
											<?=$Notify->message;?>
										</a>
									</li>
									<? endforeach; ?>
									<? else: ?>
									<li>
										<a href="#">No Notifications!</a>
									</li>
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

      <div class="content">
        <div class="container-fluid">
        <div class="row" >
          <div class="col-lg-12" >
            @include('Layouts.Navbar', ['page' => $page])
          </div>
        </div>
      </div>
