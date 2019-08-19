<?php
include_once'../dbcon.php';
	$today = date("Y-m-d"); 

	$timediff = "select * from queue_log where queue_No = '1001' and date(queue_Date)='2019-08-08' order by queue_Date desc limit 2";
	$res =  mysqli_query($link,$timediff);

	$no = 0;
	foreach ($res as $key) { // repair here
		++$no;
		if ($no==1) {
			$consult_time = $key['queue_Date'];
		}
		else{
			$waiting_time = $key['queue_Date'];
		}
	}

	$waiting = new DateTime($waiting_time);
	$differ_time = $waiting->diff(new DateTime($consult_time));
	$minutes = $differ_time->i * 2;
	echo $minutes.'<br>';
	echo $differ_time->i.' minutes '.$differ_time->s.'seconds<br>';
?>