<?php
include_once'../dbcon.php';

$temp = array();
$ic = $_GET['ic'];
$password = $_GET['password'];
$token = $_GET['token'];

$sql = "select * from patient where patient_IC = '$ic'";
$res = mysqli_query($link,$sql);
$response1 = mysqli_num_rows($res);

$sql = "select * from patient where patient_IC = '$ic' and patient_Phone = '$password'";
$res = mysqli_query($link,$sql);
$response2 = mysqli_num_rows($res);

if ($response1==0) {
	$array = [
		'response'=>'0'
	];
	array_push($temp, $array);
}
elseif ($response2==0) {
	$array = [
		'response'=>'2'
	];
	array_push($temp, $array);
}
else {
	$query = "update patient set token = '$token' where patient_IC = '$ic'";
	mysqli_query($link,$query);

	$array = [
		'response'=>'1'
	];
	array_push($temp, $array);
}
echo json_encode($temp);

?>