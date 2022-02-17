<?php
echo "sending a message to a target program, program-2, through a socket\n";
/*
 * Target program IP address
 */
$ipaddress = '127.0.0.1';

/* 
 * Target program port number
 */
$port = '10003';

/*
 * Create a socket
 */
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
echo "Socket created\n";
shell_exec("program-2.php");

/*
 * Connect to the socket
 */
echo "Attempting to connecto to '$ipaddress' on port '$port'...\n";
$result = socket_connect($socket, $ipaddress, $port);
echo "Connected to socket\n";

/*
 * Send a message to the socket
 */
// $data = "This is a message from program-1";
// echo "Sending message '$data' to socket\n";
$json = '{"name":"John", "age":30}';
$json_hashed = hash_hmac('sha256', $json, 'secret');
$request = "$json_hashed.";
$request .= $json;
echo "Sending message '$request' to socket\n";
socket_write($socket, $request, strlen($request));
echo "Message sent\n";

/*
 * Reading response from the socket
 */
echo "Reading response from socket\n\n";
$feedback = socket_read($socket, 2048);
echo "Response: $feedback\n";

/*
 * Close the socket
 */
echo "Closing socket\n";
socket_close($socket);
echo "Socket closed\n\n";
?>
