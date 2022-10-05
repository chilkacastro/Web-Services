<?php
class Response {
    public $header;
    public $payload;
    public $statuscode;  // better to separate but goes in the header 
    public $statustext;
    public $contenttype;

    /*
     * Constructor that builds a Response object
     */ 
    function __construct($payload) {
        $this->payload = $payload;
        $this->header = array();

    }

}

?>