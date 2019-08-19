<!DOCTYPE html>
<html lang="en">

<?php
include_once'../dbcon.php';
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
}

$sql = "select * from department order by department_Id asc";
$res = mysqli_query($link,$sql);

if(isset($_POST['submit'])){
    if ($_POST['dname']!='') {
        $sql = "insert into department (department_Name) values ('$_POST[dname]')";
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
    else{
        echo '<script>alert("Please fill out the form");</script>';
    }
}

if (isset($_POST['edit'])) {
    if ($_POST['dname']!='') {
        $sql = "update department set department_Name = '$_POST[dname]' where department_Id = '$_POST[did]'";
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
    else{
        echo '<script>alert("Please fill out the form");</script>';
    }
}

if (isset($_POST['delete'])) {
    $sql = "delete from department where department_Id = '$_POST[did]'";
    if(!mysqli_query($link,$sql))
    {
        ?><script>alert("Department is used by rooms.");</script><?php
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
                    <h1 class="page-header">Department</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Department Registration Form
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <form role="form" method="post" action="department.php">
                                    <div class="col-lg-12">
                                        <div class="alert alert-success alert-dismissable" style="display: none" id="success">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            Registration success. <a href="queue.php" class="alert-link">Go to Queue</a>..
                                        </div>
                                        <div class="alert alert-danger alert-dismissable" style="display: none" id="fail">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            Connection problem.
                                        </div>
                                        <div class="form-group">
                                            <label>Department Name</label>
                                            <input class="form-control" name="dname" autocomplete="false">
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="submit">Confirm</button>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-lg-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Department List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th style="width: 20%">Department ID</th>
                                        <th>Department Name</th>
                                        <th style="width: 20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($res as $key) { ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $key['department_Id']; ?></td>
                                        <td class="center"><?php echo $key['department_Name']; ?></td>
                                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-val="<?php echo $key['department_Id']; ?>" data-val2="<?php echo $key['department_Name']; ?>"><i class="fa fa-gear fa-fw"></i></button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-val="<?php echo $key['department_Id']; ?>"  data-val2="<?php echo $key['department_Name']; ?>"><i class="fa fa-trash-o  fa-fw"></i></button></td>
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
                                <h4 class="modal-title" id="editModalLabel">Edit Department</h4>
                            </div>
                            <div class="modal-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Department Name</label>
                                                <input class="form-control" id="did" name="did" autocomplete="false" type="hidden">
                                                <input class="form-control" id="dname" name="dname" autocomplete="false">
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
                                <h4 class="modal-title" id="deleteModalLabel">Delete Department</h4>
                            </div>
                            <div class="modal-body">
                                <span id="desc">Are you sure you want to delete this content?</span>
                                <input class="form-control" id="did" name="did" autocomplete="false" type="hidden">
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
          var id = button.data('val') // Extract info from data-* attributes
          var name = button.data('val2') // Extract info from data-* attributes
          var modal = $(this)
          modal.find('#did').val(id)
          modal.find('#dname').val(name)
          modal.find('#dname').attr("placeholder", name)
          modal.find('.modal-title').text('Edit '+name)
        })

        $('#deleteModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var id = button.data('val') // Extract info from data-* attributes
          var name = button.data('val2') // Extract info from data-* attributes
          var modal = $(this)
          modal.find('#did').val(id)
          modal.find('#desc').text('Are you sure you want to delete ' + name + ' content?')
          modal.find('.modal-title').text('Delete '+name)
        })
    </script>

</body>

</html>
