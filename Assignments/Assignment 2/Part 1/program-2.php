<?php
    $ipaddress = '127.0.0.1';
    $port = '10001';

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
    //$feedback = "Welcome to Program-2, you said '$buffer'\n";
    $response = "HTTP/1.1 200 OK\r\n";
    $response .= "<html><body><h1>Hello World</h1></body></html>\r\n";
    $response .= "Connection: Close\r\n\r";

    socket_write($msgsocket, $response, strlen($response));

    /*
     * Close the socket
     */
    socket_close($msgsocket);
    socket_close($socket);

?>