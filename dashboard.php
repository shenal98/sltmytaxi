<?php
include "config.php";

// Check user login or not
if (!isset($_SESSION['uname'])) {
    header('Location: index.php');
} else {
    $un = $_SESSION['uname'];
    $pwd = $_SESSION['password'];
}







//delete


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard</title>

    <!-- jquery JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Datatable JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>


    <!-- CSS DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <style>
        .order-card {
            color: #fff;
        }

        .bg-c-blue {
            background: linear-gradient(45deg, #4099ff, #73b4ff);
        }

        .bg-c-green {
            background: linear-gradient(45deg, #2ed8b6, #59e0c5);
        }

        .bg-c-yellow {
            background: linear-gradient(45deg, #FFB64D, #ffcb80);
        }

        .bg-c-pink {
            background: linear-gradient(45deg, #FF5370, #ff869a);
        }


        .card {
            border-radius: 5px;
            -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
            box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
            border: none;
            margin-bottom: 30px;
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        .card .card-block {
            padding: 25px;
        }

        .order-card i {
            font-size: 26px;
        }

        .f-left {
            float: left;
        }

        .f-right {
            float: right;
        }
    </style>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">



</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #080078;">

        <a class="navbar-brand" href="#">
            <img src="images/logo.png" style="width: 8em;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="dashboard.php">Dashboard</a>
                <a class="nav-item nav-link" href="trip_history.php">Trip History <span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="users.php">Users</a>
            </div>

        </div>
        <ul class="nav navbar-nav navbar-right">


            <form method='post' action="process.php">

                <button type="submit" value="Logout" name="but_logout" class="btn btn-outline-danger my-2 my-sm-0" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                    </svg> Logout</button>
            </form>
        </ul>


    </nav>
    <?php

    include_once('includes/dbconfig.php');
    $ref_tripd = "TripData/";
    $fetchdata_trip = $database->getReference($ref_tripd)->getValue();

    $ref_drivers = "Employee/";
    $fetchdata_drivers = $database->getReference($ref_drivers)->getValue();

    $tot_fare = 0;
    $today_tot = 0;
    $total_hires_today = 0;
    $arr_tel = array();
    $arr_driver_tel = array();
    //$i = 0;

    if ($fetchdata_trip > 0) {


        foreach ($fetchdata_trip as $key => $row) {
            $tot_fare = $tot_fare + (float)str_replace("/=", "", str_replace("Rs.", "", $row['totFare']));

            if ($row['dateTxt'] == date("d/m/Y")) {
                $today_tot = $today_tot + (float)str_replace("/=", "", str_replace("Rs.", "", $row['totFare']));
                $total_hires_today = $total_hires_today + 1;
            }
            array_push($arr_tel, $row['vnoTxt']);
        }
    }

    //driver details
    if ($fetchdata_drivers > 0) {


        foreach ($fetchdata_drivers as $key => $row) {

            array_push($arr_driver_tel, $row['phoneNumber']);
        }
    } 
    ?>

    <?php
    $unique_hire_tel = array_unique($arr_tel);
    $unique_driver_tel = array_unique($arr_driver_tel);

    //echo var_dump(array_diff($unique_driver_tel,$unique_hire_tel));

    $inactive_drivers = count(array_diff($unique_driver_tel, $unique_hire_tel));
    $active_drivers = count($unique_driver_tel) - $inactive_drivers;

    // print_r($active_drivers);
    ?>

    <div class="container">
        <br>
        <div class="row">
            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-blue order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Today</h6>

                        <h2 class="text-right"><i class="fa fa-calendar f-left"></i><span><?php echo date("Y/m/d"); ?></span></h2>
                        <p class="m-b-0">Today is <span class="f-right"><?php echo date("l"); ?></span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-green order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Time</h6>
                        <h2 class="text-right"><i class="fa fa-rocket f-left"></i><span><?php echo date("h:i a"); ?></span></h2>
                        <p class="m-b-0">Now<span class="f-right"></span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-yellow order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Active Drivers</h6>
                        <h2 class="text-right"><i class="fa fa-users f-left"></i><span><?php echo $active_drivers; ?></span></h2>
                        <p class="m-b-0">Count<span class="f-right"></span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-pink order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Inactive Drivers</h6>
                        <h2 class="text-right"><i class="fa fa-users f-left"></i><span><?php echo $inactive_drivers; ?></span></h2>
                        <p class="m-b-0">Count<span class="f-right"></span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="card bg-c-blue order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Total Fare (Whole time)</h6>
                        <h2 class="text-right"><i class="fa fa-cart-plus f-left"></i><span>Rs.<?php echo $tot_fare; ?>/=</span></h2>
                        <p class="m-b-0">Total Fare<span class="f-right"></span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-xl-6">
                <div class="card bg-c-green order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Total fare (Today)</h6>
                        <h2 class="text-right"><i class="fa fa-money f-left"></i><span>Rs.<?php echo $today_tot; ?>/=</span></h2>
                        <p class="m-b-0">Today's income<span class="f-right"></span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-6">
                <div class="card bg-c-pink order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Total Number of hires (Today)</h6>
                        <h2 class="text-right"><i class="fa fa-car f-left"></i><span><?php echo $total_hires_today; ?></span></h2>
                        <p class="m-b-0">Completed <span class="f-right"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Footer -->
    <footer class="page-footer font-small text-light" style="background-color: #080078;">

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2022 Copyright:
            <a href="#">SLT.lk</a>
        </div>
        <!-- Copyright -->

    </footer>
    <!-- Footer -->


</body>

</html>