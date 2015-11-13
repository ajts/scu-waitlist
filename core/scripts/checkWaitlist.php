<?php
$department = $_POST['department'];
//$department = "COEN";
if(file_exists("../storage/waitlists/".$department.".csv"))
	die("true");
die("false");
?>
