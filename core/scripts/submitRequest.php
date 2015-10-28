<?php
require_once(dirname(__FILE__).'/../classes/WaitlistEntry.php');

$params = array();
$params['department'] = trim($_POST['dpmnt']);
$params['course'] = trim($_POST['course']);
$params['section'] = trim($_POST['section']);
$params['fName'] = trim($_POST['fname']);
$params['lName'] = trim($_POST['lname']);
$params['studentId'] = trim($_POST['id']);
$params['email'] = trim($_POST['email']);
$params['reason'] = trim($_POST['reason']);

$request = new WaitlistEntry($params);
try {
	$request->save();
	echo "success!";
} catch(Exception $e) {
	echo $e->getMessage();
}
?>
