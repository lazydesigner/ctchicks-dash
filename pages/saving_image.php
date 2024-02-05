<?php
include '../routes.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
// header('Access-Control-Allow-Credentials: true');

// Set content type to allow all image types
header('Content-Type: image/*');


$uploaded_image = $_FILES['file'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($uploaded_image['error'] === 0) {   
        if ($uploaded_image['type'] == 'image/webp') {

            $originalImagePath = $uploaded_image['tmp_name'];

            $newImageName = 'ctchicks_'.uniqid('', true) . '.webp'; // Generate unique name for new image
            $target_dir = "../profiles/" . $newImageName;

            if (!file_exists($target_dir)) {
                if (move_uploaded_file($originalImagePath, $target_dir)) {
                    echo json_encode(['image_path' => 'profiles/' . $newImageName, 'image_name' => $newImageName, 'status' => 200]);
                } else {
                    echo json_encode(['error_msg' => 'Failed to move image : Try After Some Time', 'status' => 500]);
                }
            } else {
                echo json_encode(['error_msg' => 'File Already Exist', 'status' => 500]);
            }
        } else {
            $imageFileType = strtolower(pathinfo(basename($uploaded_image['name']), PATHINFO_EXTENSION));
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                echo json_encode(['error_msg' => 'File Type Image is Required']);
            } else {
                $originalImagePath = $uploaded_image['tmp_name'];
                $target_dir = "../profiles/";

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
            }
        }
    } else {
        die("Failed to upload image");
    }
} else {
    die("Failed to upload image");
}
