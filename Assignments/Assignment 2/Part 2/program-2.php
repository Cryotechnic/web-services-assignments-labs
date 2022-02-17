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
    
    // Split substring from buffer
    $json_hashed = substr($buffer, 0, strpos($buffer, '.'));
    $json = substr($buffer, strpos($buffer, '.') + 1);
    print("JSON: " . $json);
    print("JSON_HASHED: " . $json_hashed);

    $json_hashed_2 = hash_hmac('sha256', $json, 'secret');
    print("\nJSON HASHED 2: " . $json_hashed_2);
    $hash_isequal = hash_equals($json_hashed_2, $json_hashed);
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