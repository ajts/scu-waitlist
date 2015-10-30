<?php 
require_once(dirname(__FILE__).'/../classes/Waitlist.php');
// call this script with ajax
$course = trim($_POST['course']);
$section = trim($_POST['section']);
$department = explode(" ", $course)[0];
$waitlist = new Waitlist($department, $section, $course);

ob_start();
$waitlist->display();
$html = ob_get_clean();
die($html);

?>