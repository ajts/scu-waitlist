<?php
	// grab recaptcha library
require_once "recaptchalib.php";
$secret='6LcqABATAAAAABxfd3YDZWpcVlveBLMnNfl3nsA3';
$response=null;
$reCaptcha=new ReCaptcha($secret);
if ($_POST["g-recaptcha-response"]) {
    $response = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
}

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

if($response!=null && $response->success){
	$request = new WaitlistEntry($params);
	try {
		$request->save();
		echo "success!";
	} catch(Exception $e) {
		echo $e->getMessage();
	}
}
else {
	echo "Captcha error. Please try again if you are a person. Stop if you are a bot.";
}
echo '<br/><a href="../../student.php">Submit another request</a>';
?>
