<?php

require(dirname(__DIR__)."/models/videoconversion.php");

class VideoConversionController{

    private $videoconversion; //model
    
    function __construct()
    {
        $this->videoconversion = new VideoConversion();
    }

    function list($apikey){

        return $this->videoconversion->list($apikey);

    }

}

?>