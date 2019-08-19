<!DOCTYPE html>
<html lang="en">
<?php
    include_once'../dbcon.php';
    // session_start();

    $icno = $_POST['ic'];
    $room = $_POST['room'];
    $compare = 1000;

    $sql = "select * from patient where patient_IC = '$icno'";
    $res = mysqli_query($link,$sql);
    $count = mysqli_num_rows($res);

    // $tempCheck = "select * from temp";
    // $checkRes = mysqli_query($link,$tempCheck);
    // $tempCount = mysqli_num_rows($checkRes);

    if ($count==0) {
        ?><script>alert("Patient is not registered!");</script><?php
        header("Location: queue.php");
    }else{
        $today = date("Y-m-d"); 
        $queue = "select * from queue where date(queue_Date) = '$today'";
        $res1 = mysqli_query($link,$queue);
        $count1 = mysqli_num_rows($res1);
        if($count1==0){
            $no = '1001';
        }
        else{
            foreach ($res1 as $key) {
                $no = $key['queue_No'];
            }
            $no = $no + 1;
        }

        if ($room=='') {
            //queue sorting for balance queue to each room
            $query_room = "select * from room where room_Name like 'Consultation room%'";
            $res_room = mysqli_query($link,$query_room);
            foreach ($res_room as $val) {
                $roomCheck = $val['room_Id'];
                $query = "select * from queue where room_Id = '$roomCheck' and date(queue_Date) = '$today'";
                $result = mysqli_query($link,$query);
                $resultCount = mysqli_num_rows($result);
                if ($resultCount<=$compare) {
                    $compare = $resultCount;
                    $room = $roomCheck;
                }
            }

            $log = "insert into queue_log (queue_No,patient_IC,room_Id,queue_Status) values ('$no','$icno','$room','Waiting')";
            if(!mysqli_query($link,$log))
            {
                die('Could not connect: '.mysqli_connect_error());
            }

            $insert = "insert into queue (queue_No,patient_IC,room_Id,queue_Status) values ('$no','$icno','$room','Waiting')";
            if(!mysqli_query($link,$insert))
            {
                die('Could not connect: '.mysqli_connect_error());
            }
            ?><script>alert("Patient number have been added!");</script><?php
            header("Location: queue.php");
        }
        else{
            $log = "insert into queue_log (queue_No,patient_IC,room_Id,queue_Status) values ('$no','$icno','$room','Waiting')";
            if(!mysqli_query($link,$log))
            {
                die('Could not connect: '.mysqli_connect_error());
            }
            
            $insert = "insert into queue (queue_No,patient_IC,room_Id,queue_Status) values ('$no','$icno','$room','Waiting')";
            if(!mysqli_query($link,$insert))
            {
                die('Could not connect: '.mysqli_connect_error());
            }
            ?><script>alert("Patient number have been added!");</script><?php
            header("Location: queue.php");
        }
        
    }
?>