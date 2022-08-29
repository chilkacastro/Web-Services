<?php

echo "sending a message to a target program, program-2, through a socket.\n";

/* Target program  IP address */
$ipaddress = '127.0.0.1';

/* Target program port number */
$port = 80;

/* Create a TCP/IP socket. */
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

echo "Socket created.\n";

echo "Attempting to connect to '$ipaddress' on port '$port'...";

$result = socket_connect($socket, $ipaddress, $port);

echo "Connected to socket.\n";

/* The data, or message, to be sent to program-2 */
// $data = "This is a message from program-1.";

echo "Sending the data to program-2 ...";

$request = "DUMMY /page.html HTTP/1.1\r\n";
$request .= "Host: localhost\r\n";
$request .= "Connection: Close\r\n\r\n";

socket_write($socket, $request, strlen($request));

echo "Data sent.\n";

/* Reading response from the socket */

echo "Reading response:\n\n";

$feedback = socket_read($socket, 2048);
    
echo $feedback;

echo "Closing socket...";
socket_close($socket);
echo "Socket closed.\n\n";

?>



