<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<label for="download-url">URL:</label>
<input id="download-url" type="text" placeholder="Enter image URL...">
<button onclick="downloadImage()">Download Image</button>

<script>
    function downloadImage() {
  var url = document.getElementById('download-url').value;
  
  // Create a new element that represents the image
  var img = new Image();
  img.src = url;
  
  // Create a new link element that points to the image
  var link = document.createElement('a');
  link.href = url;
  
  // Add an event listener to the link that triggers the browser's file picker dialog
  link.addEventListener('click', function(event) {
    event.preventDefault();
    var filename = url.substring(url.lastIndexOf('/')+1);
    var suggestedName = (filename.indexOf('.') !== -1) ? filename : 'image.png';
    link.download = suggestedName;

    // Show the directory picker dialog
    window.showDirectoryPicker().then(function(directory) {

      // Open a writable stream to the selected directory
      directory.getFileHandle(suggestedName, {create: true}).then(function(fileHandle) {
        return fileHandle.createWritable().then(function(writable) {

          // Write the downloaded image file to the chosen directory
          img.addEventListener('load', function() {
            var blob = dataURItoBlob(getBase64Image(img));
            return writable.write(blob);
          });
        });
      }).catch(function(error) {
        console.error('Unable to write to file:', error);
      });
    }).catch(function(error) {
      console.error('Unable to open directory:', error);
    });
  });
  
  // Trigger the download by executing a click on the link
  link.click();
}


</script>
</body>
</html>