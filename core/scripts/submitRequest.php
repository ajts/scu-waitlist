<?php
include "../classes/waitlistEntry.php";

$departmetn = $_POST['dpmnt'];
$course = $_POST['course'];
$section = $_POST['section'];
$firstName = $_POST['fname'];
$lastName = $_POST['lname'];
$studentId = $_POST['id'];
$email = $_POST['email'];
$reason = $_POST['reason'];

$request = new WaitlistEntry($firstName, $lastName, $email, $reason, $department, $course, $section);
$request->save();
?>
