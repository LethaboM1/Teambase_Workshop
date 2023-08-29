/* Add here all your JS customizations */


function ResizeImage(maxWidth = 800, maxHeight = 800, limit=1, source='file' ) {
    if (window.File && window.FileReader && window.FileList && window.Blob) {
        var filesToUploads = document.getElementById(source).files;
        console.log(`Files to upload: ` + filesToUploads.length);
        var file = filesToUploads[0];
        if (file) { 
            var reader = new FileReader();
            // Set the image once loaded into file reader
            reader.onload = function(e) {
 
                var img = document.createElement("img");
                img.src = e.target.result;
                
                img.onload = function () {
                  var theCanvas = document.createElement("canvas");
                  var ctx = theCanvas.getContext("2d");
                  ctx.drawImage(img, 0, 0);
  
                  //var MAX_WIDTH = 400;
                  //var MAX_HEIGHT = 400;
                  var width = img.width;
                  var height = img.height;
  
                  if (width > height) {
                      if (width > maxWidth) {
                          height *= maxWidth / width;
                          width = maxWidth;
                      }
                  } else {
                      if (height > maxHeight) {
                          width *= maxHeight / height;
                          height = maxHeight;
                      }
                  }
                  theCanvas.width = width;
                  theCanvas.height = height;
                  var ctx = theCanvas.getContext("2d");
                  ctx.drawImage(img, 0, 0, width, height);

                //   console.log(`File Type: ` + file.type);
                  
                  if (dataurl = theCanvas.toDataURL(file.type)) {
                    // console.log(`base64 data = ` + dataurl);
                    $.ajax({
                        method:'post',
                        url:'includes/ajax.php',
                        data: {
                            cmd: 'upload_img',
                            image: dataurl,
                            limit: limit,
                            type: file.type
                        }, success: function (result) {
                            $("#image_list").html(result);
                        }
                    });
                  }
                }
            }
            reader.readAsDataURL(file);
 
        } else {
          console.log(`No files to resize!`);
        }
 
    } else {
        alert('The File APIs are not fully supported in this browser.');
    }
} 

function remImage ($key) {
    $.ajax({
        method:'post',
        url:'includes/ajax.php',
        data: {
            cmd:'remove_image',
            key: $key
        },
        success: function (result) {
            $("#image_list").html(result);
        },

    });
}

function alertMessage ($message, $error=true) {
    if ($error) {
        $html_message = `<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Error!</strong>&nbsp;` + $message + `
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-hidden='true' aria-label='Close'></button>
                        </div>`;              
    } else {
        $html_message = `<div class='alert success-danger alert-dismissible fade show' role='alert'>
                            <strong>Error!</strong>&nbsp;` + $message + `
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-hidden='true' aria-label='Close'></button>
                        </div>`;      
    }

     $("#alertMsg").html($html_message); 

    setInterval(function () {
            $("#alertMsg").html(``);
        }, 5000);
}