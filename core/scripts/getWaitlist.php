<?php 
require_once(dirname(__FILE__).'/../classes/Waitlist.php');
// call this script with ajax

$waitlist = new Waitlist("COEN");
$entries = $waitlist->display();

?>