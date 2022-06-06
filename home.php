<?php
include "config.php";

// Check user login or not
if (!isset($_SESSION['uname'])) {
    header('Location: index.php');
} else {
    $un = $_SESSION['uname'];
    $pwd = $_SESSION['password'];


}




// logout
if (isset($_POST['but_logout'])) {
    session_destroy();
    header('Location: index.php');
}


//delete


?>

<?php 
include_once "trip_history.php";
?>
