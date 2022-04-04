<?php
	require_once('../models/JWT.php');
	// Create CURL resource
	$url = "http://localhost/app/controllers/WebConvert.php";
	$curl = curl_init($url);

	// Various options
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	// Checks if the JWT token exists in the client's browser
	if (isset($_COOKIE['JWT'])) {
		$token = $_COOKIE['JWT'];
		$token = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $token); // remove non-printable characters from response
		$headers = array(
			"Content-Type: application/json", // set header content type to application/json
		);

		// Set headers
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$data = '{"Video": "D://GitHub//webservices-assignments-labs//Lab5//testdata//test.mp4", "JWT": "'.$token."\"}"; // set POST data
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	}
?>