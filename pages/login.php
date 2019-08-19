<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include_once'../dbcon.php';
if (isset($_SESSION["id"])) {
    header("Location:index.php");
}

function sanitizeString($var)
{
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    return $var;
}

if (isset($_POST['login']))
{
    $staffid1 = sanitizeString($_POST['staffid']);
    $staffid = strtoupper($staffid1);
    $password = sanitizeString($_POST['password']);
    

    if ($staffid == "" || $password == "")
    {
        echo "<script>alert('Please insert your Email and Password');</script>";
            //echo "window.location.href = 'index.php';</script>";
    }
    else
    {

        $query = "SELECT * FROM staff WHERE staff_Id ='$staffid' AND staff_Password = '$password' ";
        $result = mysqli_query ($link, $query) or exit("<script>alert('Email or Password is invalid');window.location.href='login.php';</script>");
        if (mysqli_num_rows($result) == 1)
        {
            $_SESSION["id"] = $staffid;
            $_SESSION['queue'] = '1000';
            $_SESSION['pID'] = '0';
            header ("Location:queue.php");
        }

        else
        {
            echo "<script>alert('Email or Password is invalid');";
            echo "window.location.href = 'login.php';</script>";
            exit;
        }
    }
}
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Healthcare Queue System</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Staff ID" name="staffid" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <!-- <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div> -->
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" name="login" class="btn btn-lg btn-success btn-block" value="Login">
                                <!-- <a href="index.php" class="btn btn-lg btn-success btn-block">Login</a> -->
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
