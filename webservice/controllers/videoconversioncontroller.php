<?php
// controllers add another layer for communication -> interface for communication 
require(dirname(__DIR__)."/models/videoconversion.php");  

class VideoConversionController{
    private $videoconversion; // model

    /*
     * Default constructor of the videoconversion controller
     */ 
    function __construct() {
        $this->videoconversion = new VideoConversion(); // initiate model VideoConversion

    }

    /*
     * Retrieves all the videoconversions
     */
    function list($apikey) {
        return $this->videoconversion->list($apikey);
    }
}

?>