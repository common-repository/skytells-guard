
<div class="" style="padding:10px 12px !important;">
<div class="col-lg-12">
<footer class="site-footer animated zoomIn clearfix site-footer-dark" ng-class="{'site-footer-dark':pluginMode}">
   <div class="site-footer-main clearfix">
      <ul class="site-share clearfix">
         <li title="Facebook"><a target="_blank" href="https://www.facebook.com/Skytells"><i class="fa fa-facebook"></i></a></li>
         <li title="Twitter"><a target="_blank" href="https://twitter.com/SkytellsInc"><i class="fa fa-twitter"></i></a></li>
         <li title="Google+"><a target="_blank" href="https://plus.google.com"><i class="fa fa-google"></i></a></li>
      </ul>
      <div class="site-copy">© <?=gmdate('Y');?> <a href="https://www.skytells.org" target="_blank">Skytells, Inc.</a></div>
   </div>
   <!-- ngIf: appVersion.current -->
   <div class="site-footer-right ng-binding ng-scope" ng-if="appVersion.current">Version <?=SFA_VERSION;?></div>
   <!-- end ngIf: appVersion.current -->
</footer>
</div>
</div>



    </div>
</div>
  
    <!--   Core JS Files   -->
    <script src="<?=SKYTELLS_ASSETS;?>/style/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="<?=SKYTELLS_ASSETS;?>/style/js/bootstrap.min.js" type="text/javascript"></script>


	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="<?=SKYTELLS_ASSETS;?>/style/js/bootstrap-checkbox-radio.js"></script>

	<!--  Charts Plugin -->
	<script src="<?=SKYTELLS_ASSETS;?>/style/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="<?=SKYTELLS_ASSETS;?>/style/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="<?=SKYTELLS_ASSETS;?>/style/js/paper-dashboard.js"></script>

	<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
	<script src="<?=SKYTELLS_ASSETS;?>/style/js/demo.js"></script>

  <script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
<!--
	<script type="text/javascript">

    	$(document).ready(function(){

        	demo.initChartist();

        	$.notify({
            	icon: 'ti-gift',
            	message: "Welcome to <b>Paper Dashboard</b> - a beautiful Bootstrap freebie for your next project."

            },{
                type: 'success',
                timer: 4000
            });

    	});

	</script>
  -->
