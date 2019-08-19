<?php 
$staff = $_SESSION['id'];
$stat = "select * from staff where staff_Id = '$staff'";
$result = mysqli_query($link,$stat);
foreach ($result as $value) {
    $detail = $value['staff_Id'].' - '.$value['staff_Name'];
}
?>
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Healthcare Queue System</a>
    </div>
    <!-- /.navbar-header -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="#"> <?php echo $detail; ?></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-user-md fa-fw"></i> Staff<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php if ($staff == 'ADMIN') { ?>
                        <li>
                            <a href="staff-reg.php"><i class="fa fa-edit fa-fw"></i> Registration</a>
                        </li>
                        <?php } ?>
                        <li>
                            <a href="staff-list.php"><i class="fa fa-table fa-fw"></i> Staff List</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-user fa-fw"></i> Patient<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php if ($staff == 'ADMIN') { ?>
                        <li>
                            <a href="forms.php"><i class="fa fa-edit fa-fw"></i> Registration</a>
                        </li>
                        <?php } ?>
                        <li>
                            <a href="tables.php"><i class="fa fa-table fa-fw"></i> Patient List</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="queue.php"><i class="fa fa-users fa-fw"></i> Queue Management</a>
                </li>
                <?php if ($staff == 'ADMIN') { ?>
                <li>
                    <a href="#"><i class="fa fa-home fa-fw"></i> Room / Department<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="room.php">Room Setting</a>
                        </li>
                        <li>
                            <a href="department.php">Department Setting</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <?php } ?>
                <li>
                    <a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>