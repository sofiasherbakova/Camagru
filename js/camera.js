"use strict";

(function() {
    let width = 900;
    let height = 0;
    let streaming = false;

    let photo = document.getElementById('origin');
    let preview = document.getElementById('preview');
    let video = document.getElementById('video');
    let canvas = document.getElementById('canvas');
    let shoot = document.getElementById('shoot');
    let discard = document.getElementById('discard');
    let save = document.getElementById('save');
    let save_btn = document.getElementById('save_btn');

    let file_upload = document.getElementById('file-upload');

	function startup() 
	{
		save_btn.disabled = true;

    	navigator.mediaDevices.getUserMedia({video: true, audio: false})
    	.then(function(stream) {
    	  video.srcObject = stream;
    	  video.play();
    	})
    	.catch(function(err) {
    	  console.log("An error occurred: " + err);
    	});

    	video.addEventListener('canplay', function(ev){
    	  if (!streaming) {
			height = video.videoHeight / (video.videoWidth/width);
    	    if (isNaN(height)) {
    	      height = width / (4/3);
    	    }
    	    video.setAttribute('width', width);
			video.setAttribute('height', height);
			video.style.display = "block";
    	    canvas.setAttribute('width', width);
			canvas.setAttribute('height', height);
			preview.style.display = "none";
    	    streaming = true;
    	  }
    	}, false);

    	shoot.addEventListener('click', function(ev){
		  takepicture();
		  save_btn.disabled = false;
    	  ev.preventDefault();
    	}, false);
		shoot.removeAttribute('disabled');
    	clearphoto();
	}
  
	function clearphoto() 
	{
      var context = canvas.getContext('2d');
      context.fillStyle = "#AAA";
      context.fillRect(0, 0, canvas.width, canvas.height);
  
      var data = canvas.toDataURL('image/png');
      photo.setAttribute('src', data);
    }
	
	function takepicture() 
	{
    	var context = canvas.getContext('2d');
		  if (width && height) 
		  {
        	canvas.width = width;
        	canvas.height = height;
       		context.drawImage(video, 0, 0, width, height);
      
			let data = canvas.toDataURL('image/png');
			video.style.display = "none";
			photo.setAttribute('src', data);
			preview.style.display = "block";
            preview.setAttribute('src', data);
            streaming = false;
            save_btn.removeAttribute("disabled");
            shoot.setAttribute('disabled', 'disabled');
            save.value = preview.src;
		  } 
		  else 
        	clearphoto();
	}
	
	function vidOff() {
        if (streaming) {
            const stream = video.srcObject;
            const tracks = stream.getTracks();

            tracks.forEach(function (track) {
                track.stop();
            });
			video.style.display = "none";
			preview.style.display = "block";
            streaming = false;
            video.srcObject = null;
            streaming = false;
        }
    }

	let startBtn = document.getElementById('startbutton');
    let upBtn = document.getElementById('file-upload');
    startBtn.addEventListener('click', startup, false);
    upBtn.addEventListener('click', vidOff, false);


	file_upload.addEventListener('change', function () {
        if (this.files && this.files[0]) {
			if (!this.files[0].type.match("image*")) 
			{
                alert("Wrong type file");
                return;
            }
            let reader = new FileReader();
            save_btn.removeAttribute("disabled");
			reader.onload = function (event) 
			{
                document.getElementById('preview')
                    .setAttribute('src', event.target.result);
                document.getElementById('origin')
                    .setAttribute('src', event.target.result);
                save.value = preview.src;
                save_btn.disabled = false;
            };
            reader.readAsDataURL(this.files[0]);
            file_upload.value = "";
        }
    }, false);
  })();