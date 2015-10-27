<?php 
$department = $_GET['department'];

$waitlist = new Waitlist($department);
$csvString = $waitlist->get();
?>