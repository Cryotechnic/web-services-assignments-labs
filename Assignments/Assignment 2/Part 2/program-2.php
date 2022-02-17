<?php
    $ipaddress = '127.0.0.1';
    $port = '10003';

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
     * Send feedback message
     */
    $known_hash = "541b0ca5735fa941eeafa37b41365a5bc0f55edaae5184136430bc1b75399209"; // Computed hash of json array
    $json = '{"name":"John", "age":30}';
    $json_hashed = hash_hmac('sha256', $json, 'secret');
    $hash_isequal = hash_equals($json_hashed, $known_hash);
    if ($hash_isequal === true) {
        $response = "Hashes match!";
    } else {
        $response = "Hashes do not match";
        print("hash status: " . var_dump($hash_isequal));
    }

    socket_write($msgsocket, $response, strlen($response));

    /*
     * Close the socket
     */
    socket_close($msgsocket);
    socket_close($socket);
?>