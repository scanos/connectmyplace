window.addEventListener("load", function(){
  // [1] GET ALL THE HTML ELEMENTS
  var video = document.getElementById("vid-show"),
      canvas = document.getElementById("vid-canvas"),
      take = document.getElementById("vid-take");
  // [2] ASK FOR USER PERMISSION TO ACCESS CAMERA
  // WILL FAIL IF NO CAMERA IS ATTACHED TO COMPUTER


//user, environment, left and right.

var constraints = { video: { width: 1280, height: 720, facingMode: "environment"}};

//
//var constraints = { video: { facingMode: "environment"}};

//         var constraints =  {width: { min: 1024, ideal: 1280, max: 1920 },
//          height: { min: 776, ideal: 720, max: 1080 },
//          facingMode: {"environment"}  } 
//        };
//navigator.mediaDevices.getUserMedia({ video : true})
navigator.mediaDevices.getUserMedia(constraints)
 .then(function(stream) {
    // [3] SHOW VIDEO STREAM ON VIDEO TAG
    video.srcObject = stream;
    video.play();

    // [4] WHEN WE CLICK ON "TAKE PHOTO" BUTTON
    take.addEventListener("click", function(){
      // Create snapshot from video
      var draw = document.createElement("canvas");
      draw.width = video.videoWidth;
      draw.height = video.videoHeight;
      var context2D = draw.getContext("2d");
   context2D.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);


      // Upload to server
      draw.toBlob(function(blob){
       var data = new FormData();
        data.append('upimage', blob);
        //data.append(1,qualityArgument);
        //data.append('fname', 'test.txt');;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', "3-upload.php", true);
        xhr.onload = function(){
          if (xhr.status==403 || xhr.status==404) {
            alert("ERROR LOADING 3-UPLOAD.PHP");
          } else {
            alert(this.response);
          }
        }
    //    xhr.send(data);

        //xhr.open("GET", "ajax_info.txt", true);
        //xhr.send();
        xhr.send(data);
  


      });

    });

  })
  .catch(function(err) {
    document.getElementById("vid-controls").innerHTML = "Please enable access and attach a camera";
  });
});
