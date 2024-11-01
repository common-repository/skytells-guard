<script type="text/javascript">


$(document).ready(function(){



    $.notify({
        icon: '{{$icon or 'ti-gift'}}',
        message: "{{$message or 'test'}}"

      },{
          type: '{{$type or 'success'}}',
          timer: 4000,
          placement: {
          from: "bottom",
          align: "right"
          }
      });
      swal({
        position: 'top-end',
        type: '{{$type or 'success'}}',
        title: '{{$message or 'Your work has been saved'}}',
        showConfirmButton: false,
        timer: 2500
      });
});
</script>
