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

$feedback = "Welcome to Program-2, You said '$buf'.\n";

socket_write($msgsock, $feedback, strlen($feedback));

socket_close($msgsock);

socket_close($sock);


?>