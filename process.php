<?php
include_once('includes/dbconfig.php');
session_start();




// logout
if (isset($_POST['but_logout'])) {
    session_destroy();
    header('Location: index.php');
}

if (isset($_POST['delete'])) {



    // echo '<script>';
    // echo 'alert("okk!")';
    // echo '</script>';
    //header('Location: trip_history.php');
    $token = $_POST['ref_toke_delete'];
    $ref = "TripData/".$token;
    $deleteData = $database->getReference($ref)->remove();
    $_SESSION['delete_msg'] = "Record has been deleted! (Ref.no - ".$token.")";
    header('Location: home.php');
}

if (isset($_POST['delete_user'])) {



    // echo '<script>';
    // echo 'alert("okk!")';
    // echo '</script>';
    //header('Location: trip_history.php');
    $token = $_POST['ref_toke_delete'];
    $del_tel = $_POST['delete_tel'];
    $ref = "Employee/".$token;
    $deleteData = $database->getReference($ref)->remove();
    
    
    // delete trip details
    $ref_trip = "TripData/";
    $fetchdata = $database->getReference($ref_trip)->getValue();

    if ($fetchdata > 0) {


        foreach ($fetchdata as $key => $row) {

            if($row['phoneTxt'] == $del_tel ){
                $database->getReference($ref_trip.$key)->remove();
            }
        }
    }

    $_SESSION['delete_user'] = "Driver has been deleted with trip history! (Ref.no - ".$token.")";
    header('Location: users.php');
}
