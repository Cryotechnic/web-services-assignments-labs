<?php
require_once('../models/JWT.php');
require_once('../models/User.php');
	// Read request payload 
	$request_body = file_get_contents('php://input');
	
	// Set header content type to application/json
	header("content-type: application/json");	

	// Decode request payload
	$data = (array) json_decode($request_body);
	$data_assoc = (array) json_decode($request_body, true);
	

	// Check if user data is valid & create JWT
	$checkJWT = new JWT();
	if ($checkJWT->is_valid($data_assoc['JWT'])) {
		$username = $checkJWT->getUsername($data_assoc['JWT']);
		$user = new User();
		$user = $user->get($username); // Get user from database
		echo "Token OK"; // Return OK
		$video = $data['Video'];
		
		// Convert Video 
		$name = date("Ymd").time();
		$user->startRequest($user->user_id,$video,$name);
		$command = "ffmpeg -i $video $name.avi";
	    system($command); // exec
	    $user->endRequest($name.'.avi');
	}
	else {
		echo "Invalid Token"; // Return error
	}
?>

