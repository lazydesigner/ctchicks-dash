<?php 
include './routes.php';
    session_start();
 session_unset();
 session_destroy();
 header('Location:'.get_url().'')

?>