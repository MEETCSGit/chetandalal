<?php
include('../config.php');
$name=$_POST['username'];
$password=$_POST['password'];
// print_r($_POST);
// //header("location:".base_url()."/lauth/downtime");
// exit;
if($_POST['action']=="Authenticate"){

	$conn = new mysqli($CFG->dbhost, $CFG->dbuser, $CFG->dbpass, $CFG->dbname);	
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 	
	$sql = "SELECT id FROM mdl_cdims_register_user where verify_email=0 and email='".mysqli_real_escape_string($conn, $_POST['username'])."'";
	
	$result = $conn->query($sql);
	/*print_r($result->num_rows);
	exit;	*/
	if ($result->num_rows == 1) {		
	   	$response['code']="0";
		$response['message']="Please verify your email address by clicking on the link sent to you in the mail from support@chetandalal.com to continue to login.";
		$respone= json_encode($response);		
		header("location:".$CFG->siteurl."/login/?message=".base64_encode($respone));
		exit;
	} 
	$conn->close();	

	$user = authenticate_user_login($name, $password);	
	if(!authenticate_user_login($name, $password))
	{		
		$response['code']="0";
		$response['message']="Invalid Login.";
		$respone= json_encode($response);		
		header("location:".$CFG->siteurl."/login/?message=".base64_encode($respone));
	}else if(complete_user_login($user))
	{
		/*echo '<pre>';
		print_r($USER);
		exit;*/
		header("location:".$CFG->siteurl."lauth/set-ci-session/".$USER->id."/?redirect_to=".$_GET['last_url']."&sesskey=$USER->sesskey");
		//header("location:http://192.168.1.100/cdims/lauth/set-ci-session/".$USER->id."/?redirect_to=".urlencode($_GET['last_url'])."&sesskey=$USER->sesskey");
		/*$response['status']="1";
		$response['code']="406";
		$response['message']="success";
		$newusedata=base64_encode(urlencode(base64_encode(json_encode($user))));
		$randomToken = $newusedata.':'.hash('sha256',uniqid(mt_rand(), true).uniqid(mt_rand(), true));
		$randomToken .= ':'.hash_hmac('md5', $randomToken, 'r@jeshN@D@r');	
		$response['longToken']=$randomToken;
		echo json_encode($response);
		exit;*/
	}
}else{
	$response['status']="0";
	$response['code']="406";
	$response['message']="Forbidden";
	echo json_encode($response);
	exit;
}

?>