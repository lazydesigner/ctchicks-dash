<?php

$image_path = 'https://cdn.ctchicks.com/profiles/'.$_POST['path'];
// $image_path = './profiles/'.$_POST['path'];

if(unlink($image_path)){echo json_encode(['status'=>200]);}else{echo json_encode(['status'=>500]);}

?>