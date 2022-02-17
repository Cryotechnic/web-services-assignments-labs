<?php
$ipaddress = '127.0.0.1';
$port = '10005';

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

/*
* Bind program to the socket (listen on address and port)
*/
socket_bind($socket, $ipaddress, $port);

/*
* Listen for connections
*/
socket_listen($socket);

/*
* Accept a connection
*/
echo "Waiting for a message...\n";
$msgsocket = socket_accept($socket);
$buffer = socket_read($msgsocket, 2048);
echo "Message received: $buffer\n";

/*
* Hash Computing
*/
//$known_hash = "541b0ca5735fa941eeafa37b41365a5bc0f55edaae5184136430bc1b75399209"; // Computed hash of JSON array

// Split substring from buffer
$json_hashed_enc = substr($buffer, 0, strpos($buffer, '.'));
$json_hashed = substr($buffer, strpos($buffer, '.') + 2);
$iv = substr($buffer, strpos($buffer, '.') + 3); // FIXME: Substring is not working

print("JSON_HASHED_ENC: $json_hashed_enc\n");
print("JSON_HASHED: $json_hashed\n");
print("IV: $iv\n");

// $json = '{"name":"John", "age":30}';
// $json_hashed = hash_hmac('sha256', $json, 'secret');
// print("\nJSON HASHED: " . $json_hashed);

// OpenSSL variables that need to be initialized for hash computing
$cipher = "aes-128-gcm";
// $iv = 12;
$key = 'hashed_secret';
$tag = "GCM";

// Decrypt the message & compare the hash
$json_hashed_decrypt = openssl_decrypt($json_hashed, $cipher, $key, $options=0, $iv, $tag);
print("\n\nDecrypted JSON Hashed: " . $json_hashed_decrypt . "\n");

// $json_hashed_encrypt = openssl_encrypt($json_hashed, $cipher, $key, $options=0, $iv, $tag);
$encrypt_isequal = strcmp($buffer, $json_hashed_decrypt); // Comparing received hash from local hash

/**
 * Response
 */
if ($encrypt_isequal != 0) {
    $response = "Encryption signature does not match.";
} else {
    $response = "Encryption signature matches!";
    // Debug
    // print($encrypt_isequal . "\nBUFFER: " . $buffer . "\nHASHED: " . $json_hashed_encrypt);
}
socket_write($msgsocket, $response, strlen($response));

/*
* Close the socket
*/
socket_close($msgsocket);
socket_close($socket);
?>