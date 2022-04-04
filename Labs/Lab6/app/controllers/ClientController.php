<?php
   require_once('../models/JWT.php');

   // Create CURL resource
   $url = "http://localhost/app/controllers/WebController.php";
   $curl = curl_init($url);

   // Various options
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_POST, true);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

   // Set header content type to application/json
   $headers = array(
      "Content-Type: application/json",
   );
   curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

   // Set POST data
   $data = '{"username": "Ron", "password": 1234}';

   // Set POST data in CURL
   curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

   $resp = curl_exec($curl);
   curl_close($curl); // close curl resource to free up system resources
   echo $resp; // echo response data

   $result = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $resp); // remove non-printable characters from response

   // Save JWT token to the client's browser
   setcookie("JWT", $resp, time() + 3600);
   $jwt = new JWT();
   $jwt->is_valid($result);
?>