<!DOCTYPE html>
<html lang="en">
<?php
    include_once'../dbcon.php';
    include '../sendnotification.php';
    session_start();
    if (!isset($_SESSION["id"])) {
        header("Location: login.php");
    }
    
    $curQueue = $_SESSION['queue'];
    $staff = $_SESSION['id'];
    
    $today = date("Y-m-d");   

    if ($staff == 'ADMIN') {
        $room_queue = false;
    }else{
        $room_queue = true;
        $check = "select * from room where staff_Id = '$staff'";
        $result = mysqli_query($link,$check);
        foreach ($result as $data) {
            $roomID = $data['room_Id'].' - '.$data['room_Name'];
        }
    }
    

    $list = "select * from queue q left join room r on q.room_Id = r.room_Id left join patient p on q.patient_IC=p.patient_IC where date(q.queue_Date) = '$today' and queue_Status != 'Complete' order by q.queue_Date asc";
    $listres = mysqli_query($link,$list);

    if ($staff != 'ADMIN') {
        $roomlist = "select * from queue q left join room r on q.room_Id = r.room_Id left join patient p on q.patient_IC=p.patient_IC where date(q.queue_Date) = '$today' and queue_Status != 'Complete' and q.room_Id = '$roomID' order by q.queue_Date asc";
        $roomlistres = mysqli_query($link,$roomlist);
    }

    if ($staff != 'ADMIN') {
        $sql = "select * from queue q, patient p where date(q.queue_Date) = '$today' and q.queue_Status = 'Waiting' and q.room_Id = '$roomID' and q.patient_IC=p.patient_IC order by queue_Date asc";
    } else {
        $sql = "select * from queue q, patient p where date(q.queue_Date) = '$today' and q.queue_Status = 'Waiting' and q.patient_IC=p.patient_IC order by queue_Date asc";
    }
    $res = mysqli_query($link,$sql);
    $count = mysqli_num_rows($res);
    if ($count==0) {
        $lastNo = 0;
    }else{
        foreach ($res as $key) {
            $firstNo = $key['queue_No'];
            break;
        }
        foreach ($res as $key) {
            $lastNo = $key['queue_No'];
        }
    }

    if (isset($_POST['call'])) {
        if (($curQueue==$lastNo)||($curQueue>$lastNo)) {
            ?><script>alert("Impossible choice!");</script><?php
        }
        elseif ($_POST['patient_no']==null) {
            ?><script>alert("No number in queue!");</script><?php
        }
        else{
            $data = explode('-',$_POST['patient_no']);
            $curQueue = $data[0];
            $pID = $data[1];
            $query = "select * from queue where date(queue_Date) = '$today' and queue_No = '$curQueue'";
            $result = mysqli_query($link,$query);
            foreach ($result as $key) {
                $patientIC = $key['patient_IC'];
            }

            $log = "insert into queue_log (queue_No,patient_IC,staff_Id,room_Id,queue_Status) values ('$curQueue','$patientIC','$staff','$roomID','Consult')";
            mysqli_query($link,$log);

            $sql = "update queue set queue_Status = 'Consult', staff_Id = '$staff', room_Id = '$roomID' where date(queue_Date) = '$today' and queue_No = '$curQueue'";
            mysqli_query($link,$sql);
            $_SESSION['queue'] = $curQueue;
            $_SESSION['pID'] = $pID;
            sendNotificationToCurrent($pID);//send notification for called patient
            sendNotificationToWaiting($curQueue,$roomID);//send notification for waiting patient
            header("Refresh:0");
        }
    }
    
    if (isset($_POST['redirect'])) {
        if ($_POST['pid']==0) {
            echo $_POST['room'];
            ?><script>alert("Invalid Patient ID!");</script><?php
        }
        else{
            if ($_POST['room']==3||$_POST['room']==0) {
                $update = "update queue set queue_Status = 'Discharge', room_Id = '$_POST[room]' where patient_IC = '$_POST[pid]' and queue_No = '$curQueue'";

                $log = "insert into queue_log (queue_No,patient_IC,staff_Id,room_Id,queue_Status) values ('$curQueue','$_POST[pid]','$staff','$_POST[room]','Discharge')";
                mysqli_query($link,$log);
            }else{
                $update = "update queue set queue_Status = 'Waiting', room_Id = '$_POST[room]' where patient_IC = '$_POST[pid]' and queue_No = '$curQueue'";

                $log = "insert into queue_log (queue_No,patient_IC,staff_Id,room_Id,queue_Status) values ('$curQueue','$_POST[pid]','$staff','$_POST[room]','Waiting')";
                mysqli_query($link,$log);
            }
            if(!mysqli_query($link,$update))
            {
                die('Could not connect: '.mysqli_connect_error());
            }   
            $_SESSION['queue'] = '1000';
            $_SESSION['pID'] = '0';
            header("Refresh:0");
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

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

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
                    <h1 class="page-header">Queue</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12 col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Patient Queue
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <?php if ($staff == 'ADMIN') { ?>
                                <div class="col-lg-3 hidden">
                                <?php } else { ?>
                                <div class="col-lg-3">   
                                <?php } ?>
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-users fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge"><?php echo $curQueue; ?></div>
                                                    <div>Current Consulting</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#" data-toggle="modal" data-target="#redirectModal">
                                            <div class="panel-footer">
                                                <span class="pull-left">Redirect Patient</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?php if ($staff == 'ADMIN') { ?>
                                <div class="col-lg-3 hidden">
                                <?php } else { ?>
                                <div class="col-lg-3">   
                                <?php } ?>
                                    <div class="panel panel-green">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-list-alt fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge"><?php echo $lastNo; ?></div>
                                                    <div>Latest Queue</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#" data-toggle="modal" data-target="#callModal">
                                            <div class="panel-footer">
                                                <span class="pull-left">Call Queue</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <form role="form" action="qrcode.php" method="post">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>New IC</label>
                                        <input class="form-control" name="ic">
                                        <p class="help-block">Example: 950321105286</p>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add To Queue</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Room</label>
                                        <select class="form-control" name="room">
                                            <option value="">--- Select Here ---</option>
                                            <?php $sqlroom = "select * from room";
                                            $resroom = mysqli_query($link,$sqlroom);
                                            foreach ($resroom as $value) {
                                                echo '<option value="'.$value['room_Id'].'">'.$value['room_Name'].'</option>';
                                            } ?>
                                        </select>
                                        <p class="help-block">*Leave blank if not an appointment</p>
                                    </div>
                                </div>
                                </form>
                                <div class="modal fade" id="callModal" tabindex="-1" role="dialog" aria-labelledby="callModalLabel" aria-hidden="true">
                                    <form method="post">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="callModalLabel">Call Queue</h4>
                                                </div>
                                                <div class="modal-body">
                                                    Call for queue number:
                                                    <select class="form-control" name="patient_no">
                                                        <?php 
                                                        foreach ($res as $value) {
                                                            if ($value['queue_No']==$firstNo) {
                                                                echo '<option value="'.$value['queue_No'].'-'.$value['patient_IC'].'" selected>'.$value['queue_No'].' - '.$value['patient_Name'].'</option>';
                                                            }else{
                                                                echo '<option value="'.$value['queue_No'].'-'.$value['patient_IC'].'">'.$value['queue_No'].' - '.$value['patient_Name'].'</option>';
                                                            }
                                                        } ?>
                                                    </select>
                                                    Please confirm your decision.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" name="call">Confirm</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                    </form>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div class="modal fade" id="redirectModal" tabindex="-1" role="dialog" aria-labelledby="redirectModalLabel" aria-hidden="true">
                                    <form method="post">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="redirectModalLabel">Redirect Patient to Other Room</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Patient I/C</label>
                                                                <input class="form-control" placeholder="<?php echo $_SESSION['pID']; ?>" disabled>
                                                                <input class="form-control" name="pid" value="<?php echo $_SESSION['pID']; ?>" type="hidden">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Room</label>
                                                                <select class="form-control" name="room">
                                                                    <?php $sqlroom = "select * from room";
                                                                    $resroom = mysqli_query($link,$sqlroom);
                                                                    foreach ($resroom as $value) {
                                                                        echo '<option value="'.$value['room_Id'].'">'.$value['room_Name'].'</option>';
                                                                    } ?>
                                                                    <option value='0'>Discharge</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" name="redirect">Confirm</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                    </form>
                                    <!-- /.modal-dialog -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" <?php echo ($room_queue == false) ?'hidden': ''; ?>>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Room <?php echo $roomID; ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Queue No</th>
                                        <th>Patient I/C</th>
                                        <th>Queue Time</th> 
                                        <th>Status</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($roomlistres as $key) { ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $key['queue_No']; ?></td>
                                        <td><?php echo $key['patient_IC'].' - '.$key['patient_Name']; ?></td>
                                        <td class="center"><?php echo $key['queue_Date']; ?></td>
                                        <td class="center"><?php echo $key['queue_Status']; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Overall Queue List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example1">
                                <thead>
                                    <tr>
                                        <th>Queue No</th>
                                        <th>Patient I/C</th>
                                        <th>Room No/Name</th>
                                        <th>Queue Time</th> 
                                        <th>Status</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listres as $key) { ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $key['queue_No']; ?></td>
                                        <td><?php echo $key['patient_IC'].' - '.$key['patient_Name']; ?></td>
                                        <td><?php echo $key['room_Id'].' - '.$key['room_Name']; ?></td>
                                        <td class="center"><?php echo $key['queue_Date']; ?></td>
                                        <td class="center"><?php echo $key['queue_Status']; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
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

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $('#dataTables-example1').DataTable({
            responsive: true
        });
    });
    </script>
</body>

</html>
