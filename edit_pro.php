<?php 
include './routes.php';
include './connection.php';

$user_id = $_POST['id_user'];
$profile_count = $_POST['identity'];

$callgirl_escort = $_POST['callgirl-escort'];
$identity = $profile_count;
if($callgirl_escort == "call-girls"){
    $identity_cat = 'call-girl-'.$profile_count;
}else{
    $identity_cat = 'escort-'.$profile_count;
}

$cities = $_POST['cities'];
$areas = $_POST['areas'];
$page_title = $_POST['page_title'];
$meta_description = $_POST['meta_description'];
$profile_name = $_POST['profile_name'];
$profile_age = $_POST['profile_age'];
$profile_height = explode("'",$_POST['profile_height']);

$profile_height ='';
if(!empty($profile_height[0])){
    $profile_height = $profile_height[0] ;
}
if(isset($profile_height[1])){
    $profile_height = "\'".$profile_height[1] ;
}

if($_POST['profile_language'] == '' || empty($_POST['profile_language'])){
    $profile_language = "Hindi , English";
}else{$profile_language = $_POST['profile_language'];}

if($_POST['profile_nationality'] == '' || empty($_POST['profile_nationality'])){
    $profile_nationality = "Indian";
}else{$profile_nationality = $_POST['profile_nationality'];}

$profile_body_shape = json_encode($_POST['profile_body_shape']);
$cat_ = json_encode($_POST['cat_']);
$image_ = json_encode($_POST['image_']);
$image_alt_ = json_encode($_POST['image_alt_']);
$content = $_POST['content'];


$query = "UPDATE `profiles` SET `identity`=$identity,`identity_cat`='$identity_cat',`callgirl_escort`='$callgirl_escort',`cities`='$cities',`areas`='$areas',`page_title`='$page_title',`meta_description`='$meta_description',`profile_name`='$profile_name',`profile_age`=$profile_age,`profile_height`='$profile_height',`profile_language`='$profile_language',`profile_nationality`='$profile_nationality',`profile_body_shape`='$profile_body_shape',`cat_`='$cat_',`image_`='$image_',`image_alt_`='$image_alt_',`content`='$content' WHERE `profile_id` = $user_id";

$result = mysqli_query($con, $query);
if ($result) {
    echo '<script>alert("Profile Updated successfully!")</script>';
    header('Location:'.get_url().'');
} else {
    echo "<div class='error'>Cannot create new user.</div>";
}


?>