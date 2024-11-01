<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<style>
#adminmenumain,#wpadminbar {
  display:none;
}
#wpcontent, #wpfooter {
  margin-left: 0px;
  margin-top: 0px;
}
html.wp-toolbar {
  padding-top: 0px!important;
}
</style>
<title>Face ID</title>
<!-- animation CSS -->

<!-- Custom CSS -->
<link href="{{SKYTELLS_ASSETS}}/css/faceid.css" rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="login-register">
  <div class="login-box" style="width:550px; margin: 4% auto 0;">
    <div class="white-box">
      <form class="form-horizontal form-material" >

        <div class="form-group">
          <div class="col-xs-12 text-center">
            <div class="user-thumb text-center"> <img alt="thumbnail" class="img-circle" width="100" src="{{SKYTELLS_ASSETS}}/images/lock-icon.png">
              <h3>Face ID</h3>
              <p id="subt">Please show us your face, eyes and emotions in order to verify your identity</p>
            </div>
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12 text-center">
            <canvas id="demo-canvas" hidden></canvas>
            <video id="camera-stream" style="width:100%;"></video>
            <img id="snap" style="-webkit-filter: blur(16px); /* Safari 6.0 - 9.0 */
               filter: blur(16px); width:100%; height: 0px; display:none;">
               <div id="placmentVid" style=" display:none;"></div>


                <img id="imgScanning" src="{{SKYTELLS_ASSETS}}/images/face_scan.gif" style="width:100%; height:50%; display:none;">
                <h5 id="lblStatus"></h5>

                  <!-- success -->
                  <div id="suc" class="alert alert-success mb0 mt10 x-hidden" hidden role="alert"></div>
                  <!-- success -->

                  <!-- error -->
                  <div id="err" class="alert alert-danger mb0 mt10 x-hidden" hidden role="alert"></div>
                  <!-- error -->

                  <a href="#" onclick="performCheck('recognize');" class="btn btn-info btn-info"> Login</a>

        </div>

      </div>




      </form>
    </div>
  </div>










  <div class="controls" style="display:none;">
      <a href="#" id="start-camera" class="visible">Touch here to start the app.</a>
      <p id="error-message" hidden></p>
      <a href="#" id="delete-photo" title="Delete Photo" class="disabled"><i class="material-icons">delete</i></a>
      <a href="#" id="take-photo" title="Take Photo"><i class="material-icons">camera_alt</i></a>
      <a href="#" id="download-photo" download="selfie.png" title="Save Photo" class="disabled"><i class="material-icons">file_download</i></a>
  </div>
</section>
<script>var BASE = '';

function redirectHome() {
    window.location.href = "{{admin_url('index.php?faceid=true')}}";
}
</script>


<script>
var AI_SUBJECT_ID = '';
var AI_FULLNAME = '';
var AI_UID = '';
var AI_GALLARY = '';
var AI_ACTION = 'recognize';
@if ((bool)$Auto == true)
var AI_AUTO = true;
@else
var AI_AUTO = false;
@endif
var AI_TOKEN = AI_SUBJECT_ID +"{{md5('o$v(2)')}}";
var API_END_POINT = '{{SFA_ACTIONS_URL}}/FaceID.php';
var WORKER_TMR = {{$Timer or 5}};
</script>
<script src="{{SKYTELLS_ASSETS}}//js/faceid.min.js"></script>

<script src="{{SKYTELLS_ASSETS}}/js/faceid.js"></script>
</body>
</html>
