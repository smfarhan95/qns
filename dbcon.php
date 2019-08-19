<?php
//error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE );
$link = mysqli_connect("localhost","root","","test");
if(!$link)
{
	die('oops connection problem ! --> '.mysqli_connect_error());
}

?>