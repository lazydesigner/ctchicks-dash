<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="uploaded_file">
        <button name="test">test</button>
    </form>
</body>
</html>

<?php

// Check if a file is uploaded
if(isset($_POST['test'])){
    if ($_FILES['uploaded_file']['error'] == UPLOAD_ERR_OK) {
    
        // Get file details
        $originalFileName = $_FILES['uploaded_file']['name'];
        $tempFilePath = $_FILES['uploaded_file']['tmp_name'];
        $uploaded_image = $_FILES['uploaded_file'];
        
        // Convert the image to JPEG
        $jpegFilePath = 'uploads/' . pathinfo($originalFileName, PATHINFO_FILENAME) . '.jpeg';
        $image = imagecreatefromstring(file_get_contents($tempFilePath));
        imagejpeg($image, $jpegFilePath, 90);
        imagedestroy($image);
        
        // Add watermark to the JPEG image
        $watermarkFilePath = './SKOKRA+LOGO+NEW+(2).webp.png'; // Change this to the path of your watermark image
        $watermarkedFilePath = 'uploads/' . pathinfo($originalFileName, PATHINFO_FILENAME) . '_watermarked.jpeg';
        
        $image = imagecreatefromjpeg($jpegFilePath);
        $watermark = imagecreatefrompng($watermarkFilePath);
        
        $watermarkWidth = imagesx($watermark);
        $watermarkHeight = imagesy($watermark);
        
        $imageWidth = imagesx($image);
        $imageHeight = imagesy($image);
        
        // Place the watermark on the bottom-right corner with some padding
        $positionX = ($sourceWidth - $watermarkWidth) / 2;
        $positionY = ($sourceHeight - $watermarkHeight) / 2;
        
        imagecopy($image, $watermark, $positionX, $positionY, 0, 0, $watermarkWidth, $watermarkHeight);
        
        imagejpeg($image, $watermarkedFilePath, 90);
        
        imagedestroy($image);
        imagedestroy($watermark);
        
        // Convert the watermarked image to WebP
        $imageFileType = strtolower(pathinfo(basename($uploaded_image['name']), PATHINFO_EXTENSION));
        // if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        //     echo json_encode(['error_msg' => 'File Type Image is Required']);
        // } else {
            $originalImagePath = $watermarkedFilePath;
            $target_dir = "./profiles/";
    
            $webpImagePath = uniqid('ctchicks_') . '.webp';        
    
            // $webpImagePath = pathinfo(basename($uploaded_image['name']), PATHINFO_FILENAME) . '.webp';
    
            $target_dir_path = $target_dir . $webpImagePath;
    
            if (!file_exists($target_dir_path)) {
    
                $image = imagecreatefromstring(file_get_contents($originalImagePath));
                imagewebp($image, $target_dir_path, 85);
    
                imagedestroy($image);
                if (file_exists($target_dir_path)) {
                    echo json_encode(['image_path' => 'profiles/' . $webpImagePath, 'image_name' => $webpImagePath, 'status' => 200]);
                } else {
                    echo json_encode(['error_msg' => 'Failed to convert or move image', 'status' => 500]);
                }
            }else {
                echo json_encode(['error_msg' => 'File Already Exist : Image with similar name', 'status' => 500]);
            }
        // }
        
        // Cleanup: Remove the temporary JPEG and watermarked JPEG files
        unlink($jpegFilePath);
        unlink($watermarkedFilePath);
        
        echo 'Image processed successfully!';
    } else {
        echo 'Error uploading file.';
    }
}

?>
