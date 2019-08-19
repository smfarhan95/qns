<!DOCTYPE html>
<html lang="en">

<?php
include_once'../dbcon.php';
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
}

$sql = "select r.room_Id, r.room_Name, d.department_Name, d.department_Id, s.staff_Name, s.staff_Id from room r left join department d on d.department_Id=r.department_Id left join staff s on r.staff_Id=s.staff_Id order by room_Id asc";
$res = mysqli_query($link,$sql);

$staff = "select * from staff where staff_Id = '$_SESSION[id]'";
$staffRes = mysqli_query($link,$staff);

if(isset($_POST['submit'])){
    if ($_POST['department']==''||$_POST['rno']==''||$_POST['rname']==''||$_POST['staff']=='') {
        echo '<script>alert("Please fill out the form");</script>';
    }
    else{
        $sql = "insert into room (room_Name,room_Id,department_Id,staff_Id) values ('$_POST[rname]','$_POST[rno]','$_POST[department]','$_POST[staff]')";
        if(!mysqli_query($link,$sql))
        {
            ?><script>alert("Room number already in used.");</script><?php
        }
        else
        {
            ?><script>alert("Success");</script><?php
            header("Refresh:0");
        }
    }
}

if (isset($_POST['edit'])) {
    if ($_POST['did']==''||$_POST['rname']=='') {
        echo '<script>alert("Please fill out the form");</script>';
    }
    else{
        $sql = "update room set department_Id = '$_POST[did]', room_Name = '$_POST[rname]', staff_Id = '$_POST[sid]' where room_Id = '$_POST[rid]'";
        if(!mysqli_query($link,$sql))
        {
            echo '<script>alert("Staff already registered on other room");</script>';
        }
        else
        { 
            echo '<script>alert("Success");</script>';
            header("Refresh:0");
        }
    }
}

if (isset($_POST['delete'])) {
    $sql = "delete from room where room_Id = '$_POST[rid]'";
    if(!mysqli_query($link,$sql))
    {
        die('Could not connect: '.mysqli_connect_error());
    }
    else
    { 
        echo '<script>alert("Success");</script>';
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
                    <h1 class="page-header">Room</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Room Registration Form
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post" action="room.php">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="alert alert-success alert-dismissable" style="display: none" id="success">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            Registration success. <a href="queue.php" class="alert-link">Go to Queue</a>..
                                        </div>
                                        <div class="alert alert-danger alert-dismissable" style="display: none" id="fail">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            Connection problem.
                                        </div>
                                        <div class="form-group">
                                            <label>Room Name</label>
                                            <input class="form-control" name="rname" autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Room No</label>
                                            <input class="form-control" name="rno" autocomplete="false">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <?php $sql = "select * from department";
                                            $sqlres = mysqli_query($link,$sql); ?>
                                            <label>Department</label>
                                            <select class="form-control" name="department">
                                                <option value="">--- Select here ---</option>
                                                <?php foreach ($sqlres as $row) {
                                                    echo '<option value="'.$row['department_Id'].'">'.$row['department_Name'].'</option>';
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <?php $sql = "select * from staff where staff_Id != 'admin'";
                                            $sqlres = mysqli_query($link,$sql); ?>
                                            <label>Staff</label>
                                            <select class="form-control" name="staff">
                                                <option value="">--- Select here ---</option>
                                                <?php foreach ($sqlres as $row) {
                                                    echo '<option value="'.$row['staff_Id'].'">'.$row['staff_Id'].' ('.$row['staff_Name'].')</option>';
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary" name="submit">Confirm</button>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                    </div>
                                </div>
                            </form>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Room List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Room No</th>
                                        <th>Room Name</th>
                                        <th>Department</th>
                                        <th>Staff</th>
                                        <th style="width: 22%">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($res as $key) { ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $key['room_Id']; ?></td>
                                        <td class="center"><?php echo $key['room_Name']; ?></td>
                                        <td class="center"><?php echo $key['department_Name']; ?></td>
                                        <td class="center"><?php
                                            if ($key['staff_Id']=='') {
                                                echo "-";
                                            } else{
                                                echo $key['staff_Id'].' ('.$key['staff_Name'].')';
                                            }  ?>
                                        </td>
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-val="<?php echo $key['room_Id']; ?>" data-val2="<?php echo $key['room_Name']; ?>" data-val3="<?php echo $key['department_Id']; ?>" data-val4="<?php echo $key['staff_Id']; ?>"><i class="fa fa-gear fa-fw"></i></button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-val="<?php echo $key['room_Id']; ?>"  data-val2="<?php echo $key['room_Name']; ?>"><i class="fa fa-trash-o  fa-fw"></i></button></td>
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
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <form method="post">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="editModalLabel">Edit Room</h4>
                            </div>
                            <div class="modal-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Room No</label>
                                                <input class="form-control" id="rid" name="rid" autocomplete="false" type="hidden">
                                                <input class="form-control" id="disabledId" type="text" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label>Room Name</label>
                                                <input class="form-control" id="rname" name="rname" autocomplete="false" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php $edit = "select * from department";
                                                $editres = mysqli_query($link,$edit); ?>
                                                <label>Department</label>
                                                <select class="form-control" id="dep" name="did">
                                                    <option value="">--- Select here ---</option>
                                                    <?php foreach ($editres as $val) {
                                                        echo '<option value="'.$val['department_Id'].'">'.$val['department_Name'].'</option>';
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php $edit = "select * from staff where staff_Id != 'admin'";
                                                $editres = mysqli_query($link,$edit); ?>
                                                <label>Staff</label>
                                                <select class="form-control" id="staff" name="sid">
                                                    <option value="">--- Select here ---</option>
                                                    <?php foreach ($editres as $val) {
                                                        echo '<option value="'.$val['staff_Id'].'">'.$val['staff_Id'].' ('.$val['staff_Name'].')</option>';
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="edit">Confirm</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                </form>
                <!-- /.modal-dialog -->
            </div>
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <form method="post">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="deleteModalLabel">Delete Room</h4>
                            </div>
                            <div class="modal-body">
                                <span id="desc">Are you sure you want to delete this content?</span>
                                <input class="form-control" id="rid" name="rid" autocomplete="false" type="hidden">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="delete">Confirm</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                </form>
                <!-- /.modal-dialog -->
            </div>
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

        $('#editModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var rid = button.data('val') // Extract info from data-* attributes
          var name = button.data('val2') // Extract info from data-* attributes
          var did = button.data('val3') // Extract info from data-* attributes
          var sid = button.data('val4') // Extract info from data-* attributes
          var modal = $(this)
          modal.find('#rid').val(rid)
          modal.find('#dep').val(did)
          modal.find('#staff').val(sid)
          modal.find('#disabledId').attr("placeholder", rid)
          modal.find('#rname').attr("placeholder", name)
          modal.find('#rname').val(name)
        })

        $('#deleteModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var rid = button.data('val') // Extract info from data-* attributes
          var name = button.data('val2') // Extract info from data-* attributes
          var modal = $(this)
          modal.find('#rid').val(rid)
          modal.find('#desc').text('Are you sure you want to delete ' + name + '(' + rid + ') content?')
        })
    </script>

</body>

</html>
