<?php

$ipaddress = '127.0.0.1';
$port = 10000;

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

/* Bind the program to a socket, i.e., make the program listen to the specified port number */
socket_bind($sock, $ipaddress, $port);

socket_listen($sock, 5);

/* Wait for and then read the message when it comes */
echo "waiting for a message...\n";

$msgsock = socket_accept($sock);

$buf = socket_read($msgsock, 2048);

echo "Received message: $buf\n";

/* Write and send a feedback message */

// $feedback = "Welcome to Program-2, You said '$buf'.\n";
$response = "You've reached the HTTP server. Welcome! \r\n\r\n";
$response .= "This is a response from program 2\r\n\r\n";
$response .= "The purpose of this Lab 1.2 is to simulate an HTTP Request and HTTP Response between a web browser and an HTTP server.\r\n\r\n";

socket_write($msgsock, $response, strlen($response));

socket_close($msgsock);

socket_close($sock);

?>
