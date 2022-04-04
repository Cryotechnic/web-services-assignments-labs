<?php
require_once('../models/JWT.php');
require_once('../models/User.php');
	// Read request payload
	$token = "mytoken";
	$request_body = file_get_contents('php://input');
	
	// Set header content type to application/json 
	header("content-type: application/json");	

	// Send response data
	$data = (array) json_decode($request_body);
	$data_assoc = (array) json_decode($request_body, true);
	
	// Check if data from user is valid & create JWT
	$user = new User();
	$user = $user->get($data_assoc['username']);
	if(password_verify($data_assoc['password'], $user->password_hash)){
		$jwt = new JWT();
		$token = $jwt->generate($data);
		echo $token; // Display token to client
		}
	else {
		echo "Invalid credentials"; // Send error message
	}
?>













