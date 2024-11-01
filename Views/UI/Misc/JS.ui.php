<script>
$(document).ready(function() {
  $('[data-toggle="tooltip"]').tooltip();
  $('.datatable').DataTable();


  tippy('.tippy', {

    animation: 'scale',
    duration: 400,
    arrow: true,
    position: 'right',
    theme: 'menu dark'
  });



  $('.js_blockip').click(function(){
    if ($('#bipAddr').val() == '') {
        swal("Error!", "Please write the IP Address", "error");
    }else{
      var form = $(this).data('form');
      blockIP(form);
    }

  });

  $('.js_unblockip').click(function(){
    var form = $(this).data('form');
    unblockIP(form);
  });




  $('.js_ipinfo').click(function(){
    var ip = $(this).data('ip');
    var token = $(this).data('token');
    if (ip != '' && token != '') {
      $.post(ajaxurl, { action:'sfa', SFA_AjaxAction: 'getIPInfo', token: token, ip:ip}, function( data ) {
      $.sweetModal({
        title: 'IP Info',
        content: data
      }); }); }});




  $('.js_faceid_enroll').click(function(){
    open_window('{{admin_url('admin.php?page=sfa-faceid-enroll&widget=true')}}', 'Train FaceID', 1200, 740);
  });






});






function blockIP(form) {
    swal({
    title: "IP Block",
    text: "Do you want us to Inform CloudFlare to Block This IP Also?",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Block And Inform CloudFlare",
    cancelButtonText: "Block",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm) {
    if (isConfirm) {
      $("#"+form).append('<input name="cfinform" value="true" hidden >');
      swal("Blocked!", "The IP address hs been blocked by Skytells Guard and CloudFlare!", "success");
      setTimeout(function(){
        $("#"+form).submit();
      }, 2000);


    } else {
      swal("Blocked!", "The IP Address has been blocked!", "success");
      setTimeout(function(){
        $("#"+form).submit();
      }, 100);
    }
  });
}


function unblockIP(form) {
  swal({
  title: "Unban IP",
  text: "Do you want us to Inform CloudFlare to Unblock This IP Also?",
  type: "warning",
  showCancelButton: true,

  confirmButtonClass: 'btn-danger',
  cancelButtonClass: 'btn-success',
  confirmButtonText: "Unblock From Here & CloudFlare",
  cancelButtonText: "Unblock Locally",
  closeOnConfirm: false,
  closeOnCancel: false,
   buttonsStyling: true
  },
  function(isConfirm) {
    if (isConfirm) {
      $("#"+form).append('<input name="cfinform" value="true" hidden >');
      swal("Blocked!", "The IP address hs been blocked by Skytells Guard and CloudFlare!", "success");
      setTimeout(function(){
        $("#"+form).submit();
      }, 2000);


    } else {
      swal("Blocked!", "The IP Address has been blocked!", "success");
      setTimeout(function(){
        $("#"+form).submit();
      }, 100);
    }
  });
}



function open_window(url, title, width, height) {
	var my_window;
	var center_left = (screen.width / 2) - (width / 2);
	var center_top = (screen.height / 2) - (height / 2);
	my_window = window.open(url, title, "scrollbars=1, width="+width+", height="+height+", left="+center_left+", top="+center_top);
	my_window.focus();
}

</script>
