<!DOCTYPE html>
<html lang="en">

<?php
include_once'../dbcon.php';
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
}

if(isset($_POST['submit'])){
    if ($_POST['fname']==""||$_POST['icno']==""||$_POST['nation']==""||$_POST['address']==""||$_POST['gender']==""||$_POST['contact']=="") {
        ?><script>alert("Please insert all data!");</script><?php
    }
    else{
        $sql = "insert into patient (patient_Name,patient_IC,patient_Address,patient_Sex,patient_Phone,patient_Nationality) values ('$_POST[fname]','$_POST[icno]','$_POST[address]','$_POST[gender]','$_POST[contact]','$_POST[nation]')";
        if(!mysqli_query($link,$sql))
        {
            die('Could not connect: '.mysqli_connect_error());
        }
        else
        {
            ?><script>alert("Success");</script><?php
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

    <div id="wrapper">

        <?php include"nav.php"; ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Patient Registration</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Patient Registration Form
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <form role="form" method="post" action="forms.php">
                                    <div class="col-lg-6">
                                        <div class="alert alert-success alert-dismissable" style="display: none" id="success">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            Registration success. <a href="queue.php" class="alert-link">Go to Queue</a>..
                                        </div>
                                        <div class="alert alert-danger alert-dismissable" style="display: none" id="fail">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            Connection problem.
                                        </div>
                                        <div class="form-group">
                                            <label>Full Name</label>
                                            <input class="form-control" name="fname" autocomplete="false">
                                            <p class="help-block">Full name as in IC.</p>
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" rows="3" name="address"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="gender" id="optionsRadiosInline1" value="Male" >Male
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="gender" id="optionsRadiosInline2" value="Female">Female
                                            </label>
                                        </div>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>New IC</label>
                                            <input class="form-control" name="icno" autocomplete="false">
                                            <p class="help-block">Example: 950321105286.</p>
                                        </div>
                                        <div class="form-group">
                                            <label>Nationality</label>
                                            <input class="form-control" name="nation" autocomplete="false">
                                        </div>
                                        <div class="form-group">
                                            <label>Contact Number</label>
                                            <input class="form-control" name="contact" autocomplete="false">
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="submit">Confirm</button>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                                </form>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <script type="text/javascript">
        function popupSuccess() {
          var x = document.getElementById("success");
          if (x.style.display === "none") {
            x.style.display = "block";
          } 
        } 

        function popupFail() {
          var x = document.getElementById("fail");
          if (x.style.display === "none") {
            x.style.display = "block";
          } 
        } 
    </script>

</body>

</html>
