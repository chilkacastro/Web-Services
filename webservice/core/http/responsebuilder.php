<?php 
class ResponseBuilder{
    private $response;

    // construct a response | headerfields are an array
    function __construct($headerfields, $payload) {
        $this->response = new Response($payload);

        // set the headerfields individually
        $this->addHeaderFields($headerfields); // is calling Set Properties calling 
    }
    
    //  get a response
    function getResponse() {
        return $this->response;
    }

    private function setProperties($headerfields) {  // private -> not called outside because it is not the job of outside class to set properties
        $this->response->statuscode = $headerfields["Status-Code"];
        $this->response->statustext = $headerfields["Content-Type"];
        $this->response->statustext = $headerfields["Status-Text"];
    }

    // if later on we want to add a header field then we add it by using array_merge()
    function addHeaderFields(array $headerfields) {
        $result = array_merge($this->response->header, $headerfields); //merfe to arrays
        $this->response->header = $result;
        // Make sure the individual response properties have the same values as the $header property:
        $this->setProperties($headerfields);
        $this->setHTTPHeaderFields($headerfields);
        // echo "<pre>";
        // var_dump($headerfields);
        // echo "</pre>";
    }

    function setHTTPHeaderFields(array $headerfields) {
        $statusline = 'HTTP/1.1 '.$headerfields['Status-Code'].' '.$headerfields['Status-Text'];
       
        header($statusline);
       
        header('Content-Type: '.$headerfields['Content-Type']);
    }

}   
?>