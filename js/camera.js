"use strict";

(function() {
    let width = 900;
    let height = 0;
	let streaming = false;
	let isInited = false;

    let photo = document.getElementById('origin');
    let preview = document.getElementById('preview');
    let video = document.getElementById('video');
    let canvas = document.getElementById('canvas');
    let shoot = document.getElementById('shoot');
    let discard = document.getElementById('discard');
    let save = document.getElementById('save');
    let save_btn = document.getElementById('save_btn');

    let file_upload = document.getElementById('file-upload');

    let snapchat = {
        isClicked: false,
        stickers: []
    };

    let sticker_width = 100;
    let sticker_height = 100;
    let start_pos_x = 100;
    let start_pos_y = 100;

	function startup() 
	{
		if (isInited)
			destroyStickers();
		save_btn.disabled = true;
		clear();

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
			if (!isInited)
                initStickers();
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


	function addSticker() {
		snapchat['stickers'].push({
			elem: document.getElementById('stick').getElementsByClassName('sticker')[this.id].getElementsByTagName('img')[0],
			x: start_pos_x,
			y: start_pos_y,
			isActive: false
		}
		);
		render();
	}
	function initStickers() {
		isInited = true;

		document.querySelectorAll('.sticker').forEach(item => {
			item.addEventListener('click', addSticker, false);
		})
	}

	function destroyStickers() {
		isInited = false;

		document.querySelectorAll('.sticker').forEach(item => {
			item.removeEventListener('click', addSticker, false);
		})
	}

	function render() {
		let context = canvas.getContext('2d');
		context.canvas.width = photo.width;
		context.canvas.height = photo.height;

		context.drawImage(photo, 0, 0, photo.width, photo.height);
		if (snapchat['stickers']) {
			for (let el of snapchat['stickers']) {
				if (el.isActive) {
					context.lineWidth = 5;
					context.strokeStyle = "#ffffff";
					context.strokeRect(el.x, el.y, sticker_width, sticker_width);
				}
				context.drawImage(el['elem'], el.x, el.y, sticker_width, sticker_height);
			}
		}
		let data = canvas.toDataURL('image/png');
		preview.setAttribute('src', data);
		save.value = preview.src;
	}

	function clear() {
		snapchat['stickers'] = [];
		preview.src = "img/no_image.png";
	}

	discard.addEventListener('click', function () {
		clear();
		render();
	}, false);

	function inArrayStickers(newX, newY) {
		for (let i = snapchat['stickers'].length - 1; i > -1; i--) {
			let el = snapchat['stickers'][i];
			if (newX >= el.x && newX <= el.x + sticker_width && newY >= el.y && newY <= el.y + sticker_height) {
				el.isActive = true;
				return true;
			}
		}
		return false;
	}

	document.getElementById('preview').addEventListener('click', function (event) {
		if (!snapchat['isClicked'] && inArrayStickers(event.offsetX, event.offsetY)) {
			snapchat['isClicked'] = true;
		}
		else {
			for (let el of snapchat['stickers']) {
				if (el.isActive) {
					el.x = event.offsetX - sticker_width / 2;
					el.y = event.offsetY - sticker_height / 2;
					el.isActive = false;
				}
			}
			snapchat['isClicked'] = false;
		}
		render();
	}, false);

	file_upload.addEventListener('click', function () {
		if (streaming)
			vidOff();
		if (!isInited)
			initStickers();
	}, false);

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