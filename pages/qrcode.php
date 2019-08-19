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
<!-- <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Healthcare Queue System</title>

    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/qrcode.js"></script>
    <style type="text/css" media="print">
        button{
            visibility: hidden;
        }
    </style> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<!-- </head>

<body>
    <input type="text" id="text" value="<?php echo $no; ?>" hidden>
    <div id="qrcode" style="width:400px; height:400px; margin: auto;"></div>
    <h1 style="text-align: center;"><?php echo $no; ?></h1>
    <button onclick="back()">Back</button>

    <script type="text/javascript">
    var qrcode = new QRCode(document.getElementById("qrcode"), {
        width : 400,
        height : 400
    });

    function makeCode () {      
        var elText = document.getElementById("text");
        
        if (!elText.value) {
            alert("Input a text");
            elText.focus();
            return;
        }
        
        qrcode.makeCode(elText.value);
    }

    makeCode();

    function back() {
        window.location.href = "queue.php";
    }

    </script>
</body> -->