<style type="text/css">
    .sfa-brute-force .status-yes {
        color:#27ae60;
    }
    .sfa-brute-force .status-no {
        color:#cd3d2e;
    }
    .sfa-brute-force .postbox-footer {
        padding:10px;
        clear:both;
        border-top:1px solid #ddd;
        background:#fff;
    }
    .sfa-brute-force input[type="number"] {
        width:60px;
    }
    .sfa-brute-force tr.even {
        background-color:#f5f5f5;
    }
</style>
<script type="text/javascript">
    function ResetOptions() {
        if (confirm("<?php _e('Are you sure you want to reset all options?', 'sfa-brute-force'); ?>")) {
            document.forms["reset_form"].submit();
        }
    }


</script>
@include('Layouts.Header', array("title" => 'Skytells Firewall Settings', 'page' => 'firewall'))

<div class="content">
  <div class="container-fluid">

		<div class="row">
			<div class="col-lg-12 col-sm-12">

		<div id="poststuff" class="metabox-holder">
			<div id="post-body-content">
				<div class="meta-box-sortabless">
					<!-- Rebuild Area -->


						<div class="card">
							<div class="content">
								<div class="row">
									<!--  style="margin-bottom: -8px; padding-right: 5px;" -->
									<div class="col-xs-1" style="width:3.7%;">
										<img src="
											<?= getSFAURL(); ?>/assets/images/icon.svg"  style="" height="47px">
										</div>
										<div class="col-xs-11" style="width:96.3%;">
											<h3 style="color: #3a88c9;    margin: 5px 0 2px; padding-left:0px;">Skytells Firewall</h3>
										</div>
									</div>
									<!-- Image and text -->
									<div class="sfa-desc">
										<p>The Firewall Protectes your WordPress against SQL Injection, DDoS attacks ..etc.

											<br>We're strongly recommends to enable this advanced firewall.


											</p>
										</div>
									</div>
								</div>

						</div>
						<? sfa_alert('ProFeature', ['feature' => 'Firewall']); ?>


            <form method="post" action="options.php">
              <input type="hidden" name="SFASaveAction" value="true" />
              <?php settings_fields('sfa-firewall'); ?>
                @include('Modules.Firewall-Settings')
                <br>

            <div class="row">
              <div class="col-lg-12 col-sm-12">
                @include('Modules.Firewall-Advanced')
                <br>
              </div>

              <div class="col-lg-12 col-sm-12">
                @include('Modules.Firewall-BlockedIPS')
                <br>
              </div>

              <div class="col-lg-12 col-sm-12">
                @include('Modules.Firewall-Other')
                <br>
              </div>
             </div>
            </form>

            <form id="reset_form" method="post" action="">
                <input type="hidden" name="reset" value="true" />
            </form>
</div></div></div>
@include('Layouts.Footer')
