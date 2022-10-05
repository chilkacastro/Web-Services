<?php
    // a factory class that builds requests
    require("request.php");

    class RequestBuilder {
        private $Request;

        /*
         * Constructor that will build a Request 
         */
        function __construct() {
            // Setup the Request 
            $method = $_SERVER['REQUEST_METHOD'];  // GET, POST, PUT, HEAD, OPTIONS, DELETE
            $urlparams = $_GET;        // an associative array 
            $header = getallheaders(); // an associated array
            // read the payload and make it an associative array
            parse_str(file_get_contents('php://input'), $payload);  //payload is the output not payload = 

            $this->Request = new Request($method, $urlparams, $header, $payload);
        }

        /*
         * Function to return the request
         */
        public function getRequest() {
            return $this->Request;  // this request will go to the index.php of api folder
        }
}
?>