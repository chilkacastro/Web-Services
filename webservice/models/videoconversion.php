<?php

// _DIR_ is a predefined global variable that gives the current path | gets current files' directory -> so it takes videoconversion.php's directory which is models folder
// _DIR_: C:\xampp\htdocs\webservice\models
// _DIR_ is similar to dirname(__FILE__)

// But we need to go up one level then access core/database
// dirname returns the parent directory of the given path as parameter
// dirname(_DIR_): C:\xampp\htdocs\webservice
require(dirname(__DIR__)."/core/database/dbconnectionmanager.php"); // current path in this model -> so go back one level and go back to core

class VideoConversion {
    public $id;
    public $clientid;
    public $requestdate;
    public $completiondate;
    public $originalformat;
    public $targetformat;
    public $inputfile;
    public $outpufile;

    private $conn;  // should be private 

    function __construct() {
        // need connection to dbconnectionmanager.php file
        $dbconnmanager = new DbConnectionManager();
        $this->conn = $dbconnmanager->getConnection();
    }

    // Do the CRUD functionalities/methods here

    /*
     * Retrieve the video conversion for a specific client
     */
    function list($apikey) {
        $query = "SELECT * FROM videoconversions
            WHERE clientid = 
            (SELECT id FROM clients WHERE apikey = :apikey)";  // make the query

        $statement = $this->conn->prepare($query);                             // prepare the query and make it a statement

        $statement->bindParam(':apikey', $apikey, PDO::PARAM_INT);         // bind the value of clientID

        $statement->execute();                                           // execute the statement 

        // FETCH_CLASS returns an array of objects of type videoconversions : result -> id
        // FETCH_ASSOC returns an associative array of conversions : result["id"]
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>