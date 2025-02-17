<html>
<head>
  <title>Security Warning</title>
  <style>
  #warning {
    position:fixed;
    top:0px; bottom:0px;
    left:0px; right:0px; background:#c14328; font-family:"Arial",sans-serif;
   }
   #warning .warningContent .wHeading {

    color: #fff;
}
      #warning a.closeThis
      {
        position:absolute; top:20px;
        right:20px; display:block; width:20px;
        height:20px; font-size:30px; line-height:20px;
        text-align:center; color:#fff; text-decoration:none;
        text-shadow:-1px -1px #a63922;
       }
      #warning .warningContent {
        position:absolute; top:50%; left:50%; margin:-40px 0px 0px -170px; display:block;
        width:380px; height:80px; color:#f6e2dd; text-shadow:-1px -1px #a63922;
       }
        #warning .warningContent span {
          font-size:81px; font-weight:bold; line-height:93px;
          display:block; width:20px; float:left; margin-right:5px; }

          #warning .warningContent span {
            font-size:81px; font-weight:bold; line-height:93px;
            display:block; width:20px; float:left; margin-right:5px;
}
        #warning .warningContent .wHeading
        {
          font-size:38px; font-weight:bold; line-height:45px;
          margin:0px; letter-spacing:-2px;
         }
        #warning .warningContent p {
          font-size:14px; font-weight:regular;
          line-height:16px; letter-spacing:0px; margin:0px;
          padding:0px;
        }
        #warning .warningContent p a {
          font-size:14px; font-weight:regular;
          color:#ff5559; text-decoration:underline;
         }
        </style>
        </head>

<section id="warning">
    <a href="#" class="closeThis">✕</a>
    <section class="warningContent">
    
      <h5 class="wHeading">Security Warning</h5>
      <p>This URL is not <strong>Safe</strong>! <a href="/">Go Back!</a> or <a href="/contact">Contact Us</a> immediately! Your IP Address has been saved!</p>
    </section>
  </section>
<script>
try {
  $(".closeThis").click(function(){ $("#warning").fadeOut('700'); });
} catch (e) {

} finally {

}
</script>
