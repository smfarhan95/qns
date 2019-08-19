<?php
include_once'../dbcon.php';

$temp = array();
$today = date('Y-m-d');

$sql = "select * from queue where date(queue_Date) = '$today' and queue_Status = 'Consult' order by queue_Date desc limit 1";
$res = mysqli_query($link,$sql);
$count = mysqli_num_rows($res);

if ($count==0) {
	$array = [
		'id'=>'0',
		'currentNo'=>'0'
	];
	array_push($temp, $array);
}
else {
	foreach ($res as $key) {
		$array = [
			'id'=>$key['queue_Id'],
			'currentNo'=>$key['queue_No']
		];
		array_push($temp, $array);
	}
}
echo json_encode($temp);

?>