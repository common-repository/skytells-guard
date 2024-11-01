
<div class="" style="padding:2px 2px !important;">
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

  <script src="{{ SKYTELLS_ASSETS }}//style/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="{{ SKYTELLS_ASSETS }}/style/js/bootstrap.min.js" type="text/javascript"></script>


	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="{{ SKYTELLS_ASSETS }}/style/js/bootstrap-checkbox-radio.js"></script>
  <script src="{{ SKYTELLS_ASSETS }}/js/swal.js"></script>
	<!--  Charts Plugin -->
	<script src="{{ SKYTELLS_ASSETS }}/style/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="{{ SKYTELLS_ASSETS }}/style/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    @php $key = (get_option('SFA_googleMapsKey') != false && !empty(get_option('SFA_googleMapsKey'))) ? get_option('SFA_googleMapsKey') : 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'; @endphp
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{$key}}"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="{{ SKYTELLS_ASSETS }}/style/js/paper-dashboard.js"></script>

	<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
	<script src="{{ SKYTELLS_ASSETS }}/style/js/demo.js"></script>
  <script src="{{ SKYTELLS_ASSETS }}/js/tools.js"></script>

  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>

  @if (isset($loadGoogleCharts) && $loadGoogleCharts == true)
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  @endif
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="{{ SKYTELLS_ASSETS }}/js/modals.js"></script>
@include('Misc.JS')

 </div>
</div>
