<?php
include "config.php";

//session_start();

if (isset($_POST['g-recaptcha-response'])) {
	if ($_POST['g-recaptcha-response'] == "") {
		$_SESSION['message'] = "ReCAPTCHA required!";
	}
}
if (isset($_POST['but_submit']) && $_POST['g-recaptcha-response'] != "") {

    $uname = mysqli_real_escape_string($con, $_POST['txt_uname']);
    $password = mysqli_real_escape_string($con, $_POST['txt_pwd']);


    if ($uname != "" && $password != "") {

        $sql_query = "select count(*) as cntUser from tbluser where username='" . $uname . "' and password='" . $password . "'";
        $result = mysqli_query($con, $sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];

        if ($count > 0) {
            $_SESSION['uname'] = $uname;
            $_SESSION['password'] = $password;
            header('Location: dashboard.php');
        } else {
            $_SESSION['message'] = "Invalid username or password combination!";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="css/style.css">

    <link rel="icon" href="Favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <title>SLT MY TAXI</title>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);


        body {
            margin: 0;
            font-size: .9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: left;
            background-color: #f5f8fa;
        }


        .my-form {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .my-form .row {
            margin-left: 0;
            margin-right: 0;
        }

        .login-form {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .login-form .row {
            margin-left: 0;
            margin-right: 0;
        }

        body {
            background-image: url("images/taxi.png");
            background-size: 100vw;
            
        }

        div.background {
       
            border: 2px solid black;
        }

        div.transbox {
            margin: 30px;
            background-color: #ffffff;
            border: 1px solid black;
            opacity: 0.6;
        }

        div.transbox p {
            margin: 5%;
            font-weight: bold;
            color: #000000;
        }
    </style>
</head>

<body>

    <main class="login-form">
        <div class="container">

            <div class="row justify-content-center">

                <div class="col-md-6">

                    <div style="text-align: center;">
                        <img src="images/logo.png" style="margin: 2em; width:30%; ">
                        <h2 style="color: #0fa61e;">SLT MY TAXI</h2>
                    </div>

                    <div class="card text-light " style="background-color: #050152; opacity:0.8;">
                        <div class="card-header" style="background-color:#0800a6; "><b>Sign In</b></div>
                        <div class="card-body">

                            <form method="post">
                                <?php
                                //session_start();
                                if (isset($_SESSION['message'])) {


                                ?>
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert" style="opacity:1.0;">
                                        <strong><?php echo $_SESSION['message']; ?></strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php
                                    unset($_SESSION['message']);
                                }
                                ?>
                                <div class="form-group row" style="opacity:1.0;">
                                    <label for="email_address" class="col-md-4 col-form-label text-md-right">User name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="txt_uname" class="form-control" name="txt_uname" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row" style="opacity:1.0;">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                    <div class="col-md-6">
                                        <input type="password" id="txt_pwd" class="form-control" name="txt_pwd" required>
                                    </div>
                                </div>
                                <div class="form-group row" style="opacity:1.0;">
                                    <label class="col-md-4 col-form-label text-md-right"></label>
                                    <div class="col-md-4">
                                        <div class="g-recaptcha" data-sitekey="6Lfbv_oeAAAAAC6q3NCQnwsxAq8Hb544oBM06z9O"></div>
                                    </div>
                                </div>

                                <div class="form-group row" style="opacity:1.0;">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 offset-md-4" style="opacity:1.0;">
                                    <button type="submit" class="btn btn-success" id="but_submit" name="but_submit" value="Login">
                                        Sign in
                                    </button>
                                    <a href="#" class="btn btn-link"style="opacity:1.0;">
                                        Forgot Your Password?
                                    </a>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </main>