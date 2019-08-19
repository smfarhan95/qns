<?php
require_once ('./vendor/autoload.php');

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;


    $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/secret.json');
    $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->create();
	
	$token = "cUfUK9uVGZc:APA91bFYFIcTJLJDT8mBggtwvl6pw1Gc3GgA1cl4zAhuSGHN6aswo6yY9SgAZSSxNQekwT-ickVU0oevevapm-X0zdb-3enWAm5Dzl3MDO7y4Xsrr7FDX13NB82pkpCW1-K8Ydtf7C_Z";
	$notification = Notification::fromArray([
		'title' => "This our new Event",
		'body' => "test"
	]);
	$message = CloudMessage::withTarget('token', $token)
		->withNotification($notification); // optional/ optional
	try {
			$firebase->getMessaging()->send($message);
		} catch (Exception $e) {
			echo "<script>console.log('Failed to send to ic')</script>";
		}	
	
?>
