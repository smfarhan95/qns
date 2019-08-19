<?php
include_once'../dbcon.php';

$temp = array();
$today = date('Y-m-d');
$ic = $_GET['ic'];

$sql = "select * from queue where date(queue_Date) = '$today' and patient_IC = '$ic' order by queue_Date desc limit 1";
$res = mysqli_query($link,$sql);
$count = mysqli_num_rows($res);

if ($count==0) {
	$array = [
		'patientNo'=>'0',
		'roomNo'=>'0'
	];
	array_push($temp, $array);
}
else {
	foreach ($res as $key) {
		$array = [
			'patientNo'=>$key['queue_No'],
			'roomNo'=>$key['room_Id']
		];
		array_push($temp, $array);
	}
}
echo json_encode($temp);

?>