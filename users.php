<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



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


    <!-- Data table JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <title>Users (Drivers)</title>

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
                <a class="nav-item nav-link " href="dashboard.php">Dashboard</a>
                <a class="nav-item nav-link " href="trip_history.php">Trip History <span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link active" href="users.php">Users</a>
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

    <div class="container" style="margin-top: 2%;height: 100vh;">

        <?php
        session_start();
        if (isset($_SESSION['delete_user'])) {


        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?php echo $_SESSION['delete_user']; ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
            unset($_SESSION['delete_user']);
        }
        ?>

        <table id='tblTrip' class="table table-bordered table-hover dt-responsive" style=" width: 100%; ">
            <thead style="background-color: #00bd1c;" class="text-light">
                <tr>
                    <th>Name</th>
                    <th>Phone No.</th>
                    <th>Vehicle No.</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>

                <?php

                include_once('includes/dbconfig.php');
                $ref = "Employee/";
                $fetchdata = $database->getReference($ref)->getValue();

                if ($fetchdata > 0) {


                    foreach ($fetchdata as $key => $row) {



                ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['phoneNumber']; ?></td>
                            <td><?php echo $row['vehicleNo']; ?></td>

                            <td style="text-align: center;">
                                <form method='post' action="process.php">
                                    <input type="hidden" name="ref_toke_delete" value="<?php echo $key; ?>">
                                    <input type="hidden" name="delete_tel" value="<?php echo $row['phoneNumber']; ?>">

                                    <button type="submit" value="delete_user" name="delete_user" class="btn btn-outline-danger my-2 my-sm-0" type="submit">Delete</button>
                                </form>
                            </td>

                        </tr>

                <?php }
                } else {

                    echo "<h1>Data is not available at the database!</h1>";
                } ?>
            </tbody>
        </table>
        <br>
    </div>
    <script>
        $(document).ready(function() {
            var table = $('#tblTrip').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                "order": [
                    [0, 'desc'],
                ],
                
            });
        });
        //$('.alert').alert();
    </script>



    <!-- Footer -->
    <footer class="page-footer font-small text-light" style="background-color: #080078;">

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2022 Copyright:
            <a href="#">SLT.lk</a>
        </div>
        <!-- Copyright -->

    </footer>
    <!-- Footer -->
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>


</body>

</html>