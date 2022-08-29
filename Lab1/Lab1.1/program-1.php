
<?php
echo "sending a message to a target program, program-2, through a socket.\n";

/* Target program  IP address */
$ipaddress = '127.0.0.1';

/* Target program port number */
$port = 10000;

/* Create a TCP/IP socket. */
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

echo "Socket created.\n";

echo "Attempting to connect to '$ipaddress' on port '$port'...";

$result = socket_connect($socket, $ipaddress, $port);

echo "Connected to socket.\n";

/* The data, or message, to be sent to program-2 */
$data = "This is a message from program-1.";

echo "Sending the data to program-2 ...";

socket_write($socket, $data, strlen($data));

echo "Data sent.\n";

/* Reading response from the socket */

echo "Reading response:\n\n";

$feedback = socket_read($socket, 2048);
    
echo $feedback;

echo "Closing socket...";
socket_close($socket);
echo "Socket closed.\n\n";

?>
