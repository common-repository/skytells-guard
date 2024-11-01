// Take a photo and recognize the faces on it after 5 sec.
var tmr = setTimeout(getWork, WORKER_TMR*1000);
function getWork() {
    if (AI_AUTO != false) {
      performCheck(AI_ACTION);
      clearTimeout(tmr);
    }

}


// References to all the element we will need.
var video = document.querySelector('#camera-stream'),
    image = document.querySelector('#snap'),
    start_camera = document.querySelector('#start-camera'),
    controls = document.querySelector('.controls'),
    take_photo_btn = document.querySelector('#take-photo'),
    delete_photo_btn = document.querySelector('#delete-photo'),
    download_photo_btn = document.querySelector('#download-photo'),
    error_message = document.querySelector('#error-message');


// The getUserMedia interface is used for handling camera input.
// Some browsers need a prefix so here we're covering all the options
navigator.getMedia = (navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia);


if (!navigator.getMedia) {
    displayErrorMessage("Your browser doesn't have support for the navigator.getUserMedia interface.");
} else {

    // Request the camera.
    navigator.getMedia({
            video: true
        },
        // Success Callback
        function(stream) {

            // Create an object URL for the video stream and
            // set it as src of our HTLM video element.
            video.src = window.URL.createObjectURL(stream);

            // Play the video element to start the stream.
            video.play();
            video.onplay = function() {
                showVideo();
            };

        },
        // Error Callback
        function(err) {
            displayErrorMessage("There was an error with accessing the camera stream: " + err.name, err);
        }
    );

}



// Mobile browsers cannot play video without user input,
// so here we're using a button to start it manually.
start_camera.addEventListener("click", function(e) {

    e.preventDefault();

    // Start video playback manually.
    video.play();
    showVideo();

});


function performCheck(action = 'train') {

    var snap = takeSnapshot();
    $('#camera-stream').hide();
    $('#imgScanning').fadeIn();
    $('#placmentVid').fadeIn();
    // Show image.
    image.setAttribute('src', snap);
    image.classList.add("visible");

    // Enable delete and save buttons
    delete_photo_btn.classList.remove("disabled");
    download_photo_btn.classList.remove("disabled");

    // Set the href attribute of the download button to the snap url.
    download_photo_btn.href = snap;

    // Pause video playback of stream.
    video.pause();
    // ---------- Make request ----------- //

    var header_settings = {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    };



     image_data = snap;
    var contType = (action == 'train') ? 'json' : 'application/x-www-form-urlencoded';
    var data = {
        'action':'sfa',
        'image': snap,
        'library': AI_GALLARY,
        'name': AI_SUBJECT_ID,
        'subject_id': AI_SUBJECT_ID,
        'SFA_Action': AI_ACTION,
        'sfatoken': AI_TOKEN,
        'uid':  AI_UID

    };
    $('#lblStatus').empty().append("Performing AI Features, Please wait..");
    var _this = $(this);
    $.ajax({
        url: ajaxurl,
        headers: header_settings,
        method: 'POST',
        contentType: contType,
        data: data,
        success: function(data) {
          //  console.log(data);
        performRespose(_this, data);
        },
        error: function(data){
        //    console.log(data);
        performRespose(_this, data);

        }
    });


}

take_photo_btn.addEventListener("click", function(e) {

    e.preventDefault();
    performCheck();
    // Request end -----------//
});


delete_photo_btn.addEventListener("click", function(e) {

    e.preventDefault();

    // Hide image.
    image.setAttribute('src', "");
    image.classList.remove("visible");

    // Disable delete and save buttons
    delete_photo_btn.classList.add("disabled");
    download_photo_btn.classList.add("disabled");

    // Resume playback of stream.
    video.play();

});



function performRespose(Handler, data, action) {
  var _this = Handler; var action  = AI_ACTION;
  var error =  $('#err');
  var success =  $('#suc');
   // console.log(data);
    $('#imgScanning').fadeOut();
    $("#StatusArea").fadeIn();
    if (action == 'train') {
      $('#lblStatus').empty().html('');
    }else {
        $('#lblStatus').empty().html('');
    }

  try {
      var response = JSON.parse(data);
      if(response.error) {
        $('#lblStatus').empty().html('<a class="btn btn-warning" href="admin.php?page=sfa-faceid-login?try=1">Try Again!</a>');
          if(success.is(":visible")) success.hide(); // hide previous alert
          error.html(response.message).slideDown();
      } else if(response.success) {
          if(error.is(":visible")) error.hide(); // hide previous alert
          success.html(response.message).slideDown();
      }else if(response.callback){
          $('#lblStatus').empty().html('Welcome!');
        eval(response.callback);
      } else {
            $('#subt').fadeOut();
          }
  } catch (e) {
    $('#lblStatus').empty().html('Something Went Wrong!');
  } finally {

  }


}


function showVideo() {
    // Display the video stream and the controls.

    hideUI();
    video.classList.add("visible");
    controls.classList.add("visible");
}


function takeSnapshot() {
    // Here we're using a trick that involves a hidden canvas element.

    var hidden_canvas = document.querySelector('canvas'),
        context = hidden_canvas.getContext('2d');

    var width = video.videoWidth,
        height = video.videoHeight;

    if (width && height) {

        // Setup a canvas with the same dimensions as the video.
        hidden_canvas.width = width;
        hidden_canvas.height = height;

        // Make a copy of the current frame in the video on the canvas.
        context.drawImage(video, 0, 0, width, height);

        // Turn the canvas image into a dataURL that can be used as a src for our photo.
        return hidden_canvas.toDataURL('image/png');
    }
}


function displayErrorMessage(error_msg, error) {
    error = error || "";
    if (error) {
      //  console.log(error);
    }

    error_message.innerText = error_msg;

    hideUI();
    error_message.classList.add("visible");
}


function hideUI() {
    // Helper function for clearing the app UI.

    controls.classList.remove("visible");
    start_camera.classList.remove("visible");
    video.classList.remove("visible");
    snap.classList.remove("visible");
    error_message.classList.remove("visible");
}
