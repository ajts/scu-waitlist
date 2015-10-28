<?php 
require_once(dirname(__FILE__).'/../classes/Waitlist.php');
// call this script with ajax
$course = trim($_POST['course']);
$department = explode(" ", $course)[0];
$waitlist = new Waitlist($department);

ob_start();
$waitlist->display();
$html = ob_get_clean();
die($html);

?>