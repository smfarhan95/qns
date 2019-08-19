<?php
include_once'../dbcon.php';

$temp = array();
$ic = $_GET['ic'];

$sql = "select * from patient where patient_IC = '$ic'";
$res = mysqli_query($link,$sql);
$count = mysqli_num_rows($res);

$query = "update patient set token = '' where patient_IC = '$ic'";
mysqli_query($link,$query);

$array = [
	'response'=>'1'
];
array_push($temp, $array);

echo json_encode($temp);

?>