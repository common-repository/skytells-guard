<? global $wp_version; ?>
<div class="card" style="font-size:13px;">
    <div class="header">
        <h4 class="title">Environmental Info</h4>
        <p class="category">This information based on your server's info</p>
    </div>
    <div class="content">
      <div class="content table-responsive table-full-width" style="min-height:78px;">
        PHP Version : <b><?=phpversion();?></b>
        <br>WordPress Version : <b>{{$wp_version}}</b>
        <br>Skytells Guard Version : <b>{{SFA_VERSION}}</b>
        <br>WP Debug Mode : <b>@if (defined('WP_DEBUG') && WP_DEBUG == true)<o style="color:red;">Enabled (Danger)</o>@else <o style="color:green;">Disabled</o> @endif</b>
      </div>
    </div>
  </div>
