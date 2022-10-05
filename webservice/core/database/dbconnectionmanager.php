<?php

class DBConnectionManager {
   private $user;
   private $password;
   private $host;
   private $dbname;
   private $conn;
    /*
     * Default constructor
     */
    function __construct() { // could put try catch too to for $config because it is reading a file
        // echo "config: ";
        $config = simplexml_load_file(dirname(__DIR__)."/config.xml");                // simplexml_load_file: reads an xml file into an object | config will be an object that has the <database> element
        // var_dump($config);
        $this->user = $config->database->user;  // doesnt see the first element in the config.xml file
        $this->password = $config->database->password;
        $this->host = $config->database->host;
        $this->dbname = $config->database->dbname;
    }
   
    /*
    * Method to connecting to the database
    */
    function getconnection() { // best to put the connection code in a try-catch statement
        try { // first param is the host and dbname(concatenate together), user, password) 
            $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname, $this->user, $this->password); // in php, there are two libraries to connect and one is PDO -> better because it works with other 
        }catch (PDOException $exception) {
            echo ("Database Connection error: ".$exception->getMessage());
            // Log the exception
        }

        return $this->conn; // if successful, then return the connection
   }
}   
?>