
@include('Layouts.Header', array("title" => 'Skytells Guard Settings', 'page' => 'settings'))
<script type="text/javascript">
    function ResetOptions() {
        if (confirm("<?php _e('Are you sure you want to reset all options?', 'sfa-brute-force'); ?>")) {
            document.forms["reset_form"].submit();
        }
    }


</script>


            <div class="container-fluid">
<div class="wrap">


<form method="post" action="options.php">
  <?php settings_fields('sfa-guard'); ?>

  <div class="row">
    <div class="col-xs-10">
      @include('Dashboard.Settings.Modules', ['controller' => $controller])
      @include('Dashboard.Settings.Security', ['controller' => $controller])
      @include('Dashboard.Settings.System', ['controller' => $controller])
      @include('Dashboard.Settings.CloudFlare', ['controller' => $controller])
      @include('Dashboard.Settings.Content', ['controller' => $controller])
      @include('Dashboard.Settings.GoogleMaps', ['controller' => $controller])

    </div>
    <div class="col-xs-2" style="padding:0px;">
      <div class="metabox-holder">
      <div class="wf-block wf-active" data-persistence-key="waf-options-advanced">
  			<div class="wf-block-header" style="cursor: pointer;">
  				<div class="wf-block-header-content">
  					<div class="wf-block-title">
  						<strong>{{__("Security News")}}</strong>
  					</div>
  					<div class="wf-block-header-action">
  						<div class="wf-block-header-action-disclosure"></div>
  					</div>
  				</div>
  			</div>
  			<div class="wf-block-content" style="display: block;">
          <ul class="wf-block-list">
          <li style="padding-top:4px; padding-bottom:6px; min-height:60px;">
            <img style="max-width: 100%; width: 400px;" src="{{getSFAURL()}}/assets/images/skytells-wp.png">
          </li>
          @if (!empty($news->security) && $news != false)
            <? $i = 0; ?>
          @foreach ($news->security as $n)
          @if($i == 0)
            <li style="padding:4px; padding-left:10px; border:none;"><a href="{{$n->link}}" class="tippy" title="{{$n->title}}" target="_blank">{{$n->title}}</a></li>
          @else
            <li style="padding:4px; padding-left:10px;"><a href="{{$n->link}}" class="tippy" title="{{$n->title}}" target="_blank">{{$n->title}}</a></li>
          @endif
          <? $i++; ?>
          @endforeach
          @else
            <li>There is no news at the moment!</li>
          @endif
        </ul>
        </div>
      </div>
      </div>
    </div>
  </div>




  </form>
  <form id="reset_form" method="post" action="">
      <input type="hidden" name="reset" value="true" />
  </form>
</div>
</div>
<br>
@include('Layouts.Footer')
