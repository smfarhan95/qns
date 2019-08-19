<?php
require_once ('vendor/autoload.php');

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

function sendNotificationToCurrent($ic)
{
	$link = mysqli_connect("localhost","root","","test");
	if(!$link)
	{
		die('oops connection problem ! --> '.mysqli_connect_error());
	}

	$sql = "select * from patient where patient_IC = '$ic'";
	$result = mysqli_query($link,$sql);

	foreach ($result as $key) {
		$token = $key['token'];
	}

    $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/secret.json');
    $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->create();
	
	$notification = Notification::fromArray([
		'title' => "Your number was called!!",
		'body' => "Please go to room."
	]);
	$message = CloudMessage::withTarget('token', $token)
		->withNotification($notification); // optional/ optional
	try {
			$firebase->getMessaging()->send($message);
		} catch (Exception $e) {
			echo "<script>console.log('Failed to send to ic')</script>";
		}	
}

function sendNotificationToWaiting($currentNo,$roomID)
{
	$link = mysqli_connect("localhost","root","","test");
	if(!$link)
	{
		die('oops connection problem ! --> '.mysqli_connect_error());
	}

	$today = date("Y-m-d"); 

	$timediff = "select * from queue_log where queue_No = '$currentNo' and date(queue_Date)='$today' order by queue_Date desc limit 2";
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

	$sql1 = "select * from queue q left join patient p on q.patient_IC = p.patient_IC where date(q.queue_Date) = '$today' and queue_Status = 'Waiting' and room_Id = '$roomID' order by q.queue_Date asc";
	$result1 = mysqli_query($link,$sql1);

	$loop_time = 0;
	foreach ($result1 as $key1) {
		++$loop_time;
		$token = $key1['token'];
		// $remaining = (int)$key1['queue_No']-(int)$currentNo;

		// if ($remaining<=5 && $remaining>0) 
		// {
		$estimated = $differ_time->i * $loop_time;
			$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/secret.json');
		    $firebase = (new Factory)
		        ->withServiceAccount($serviceAccount)
		        ->create();

			$notification = Notification::fromArray([
				'title' => "There are ".$estimated." minutes before your turn",
				'body' => "Please be aware for your turn."
			]);

			$message = CloudMessage::withTarget('token', $token)
				->withNotification($notification); // optional/ optional
			try {
					$firebase->getMessaging()->send($message);
				} catch (Exception $e) {
					echo "<script>console.log('Failed to send to ic')</script>";
				}
		// }
	}
}
?>
