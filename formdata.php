<?php 
include './routes.php';
include './connection.php';

$last_inserted_id = "SELECT * FROM profiles  ORDER BY profile_id DESC LIMIT 1";
$last_inserted_id_result = mysqli_query($con, $last_inserted_id);
if (!$last_inserted_id_result) {
    die("Query Failed");
}
if(mysqli_num_rows($last_inserted_id_result)>0){

    $row = mysqli_fetch_assoc($last_inserted_id_result);

    $profileId = $row['profile_id'];
}else{
    $profileId = 0 ;
}
$profile_count = 101 + $profileId;

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
if(!isset($profile_height[1])){
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


$query = "INSERT INTO `profiles`(`identity`, `identity_cat`, `callgirl_escort`, `cities`, `areas`, `page_title`, `meta_description`, `profile_name`, `profile_age`, `profile_height`, `profile_language`, `profile_nationality`, `profile_body_shape`, `cat_`, `image_`, `image_alt_`, `content`) VALUES ($identity,'$identity_cat','$callgirl_escort','$cities','$areas','$page_title','$meta_description','$profile_name',$profile_age,'$profile_height','$profile_language','$profile_nationality','$profile_body_shape','$cat_','$image_','$image_alt_','$content')";

$result = mysqli_query($con, $query);
if ($result) {
    echo '<script>alert("Profile added successfully!")</script>';
    header('Location:'.get_url().'');
} else {
    echo "<div class='error'>Cannot create new user.</div>";
}


?>