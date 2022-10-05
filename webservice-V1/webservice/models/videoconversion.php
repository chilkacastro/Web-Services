<?php

// __DIR__ is a predefined global variable that gives the cureent path
// __DIR__ : C:\xampp\htdocs\webservice\models

// But we need to go up one level then to access core/database

// dirname returns the parent directory of the given path as parameter
// dirname(__DIR__): C:\xampp\htdocs\webservice

require(dirname(__DIR__)."/core/database/dbconnectionmanager.php");

class VideoConversion{

    public $id;
    public $clientid;
    public $requestdate;
    public $completiondate;
    public $originalformat;
    public $targetformat;
    public $inputfile;
    public $outputfile;

    private $conn;

    function __construct()
    {

        $dbconnmanager = new DBConnectionManager();

        $this->conn = $dbconnmanager->getconnection();
        
    }

    // Retrieve the video conversions for a specific client using the client's api key
    function list($apikey){

        $query = 'SELECT *
                    FROM videoconversions
                    WHERE clientid =
                             (SELECT id 
                             FROM clients
                             WHERE apikey = :apikey)';

        $statement = $this->conn->prepare($query);

        $statement->bindParam(':apikey', $apikey, PDO::PARAM_INT);

        $statement->execute();

        //FETCH_CLASS returns an array of objects of type videoconversions: result->id
        // FETCH_ASSOC returns an associative array of conversions: result["id"]

        return $statement->fetchAll(PDO::FETCH_CLASS);

    }

}


?>