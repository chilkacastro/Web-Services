<?php

require(dirname(__DIR__)."/core/http/requestbuilder.php");
require(dirname(__DIR__)."/core/http/responsebuilder.php");

// request.php is already required by requestbuilder.php thus here we put require_once instead of "require"
require_once(dirname(__DIR__)."/core/http/request.php"); 
require_once(dirname(__DIR__)."/core/http/response.php"); 
// The job of this class:
// To process the HTTP request URL
// and select the appropriate controller
// instantiate the controller and call its specific function
// Then once the controller gets the data from the model
// this class would build and return a response

// Not a final code, we will have to revise this to generalize it 
require(dirname(__DIR__)."/controllers/videoconversioncontroller.php");

// processing the request, building and executing backend task, and then creating/sending the response
class API {

    // Instead of building the request here, we encapsulate the request in separate classes
    private $request;
    private $controller;
    public $response;  // the response should be public because we will need to echo it

    /*
     * 
     */
    function __construct() {
        
    }

    /*
     * 
     */
    function processRequest() {
        // create a RequestBuilder object
        $requestBuilder = new RequestBuilder();

        $this->request = $requestBuilder->getRequest();  // tightly coupled
        
        // to be revised
        $this->controller = new VideoConversionController();
        // Determine which controller function to call based on the request method
        switch($this->request->method) {
            case "GET":
                // what parameters should we pass? Where do we get it from?
                // We need the apikey to identify the specific client we are getting the video conversions of
                // What data should we expect and where to store it?
                // var_dump($controller->list($apikey));
                $this->processResponse();
                break;
            case "POST":
                break;
            case "PUT":
                break;
            case "DELETE":
                break;
            case "HEAD":
                break;
            case "OPTIONS":
                break;            
        }
    }

    function processResponse() {
        // Read the API key sent by the client
        $apikey = $this->request->urlparams['apikey']; // to get the API key value 

        // Determine the response properties
        $header = array();
        $payload = array();
        $statuscode = 0;
        $statustext = "";
        $contenttype = "";

        //  Get the data/resource
        $rawpayload = $this->controller->list($apikey);

        // Check if data was returned: the data here is the requested resource
        // If the data is found and can be returned
        // The HTTP status code of the response should be: 200
        if (count($rawpayload) > 0) {
            $statuscode = 200;
            $statustext = "OK";
        } else { // 0 rows in the databasse because the resource was not found
            $statuscode = 404;
            $statustext = "Not Found";

            $rawpayload = json_encode(array('message' => "Possibly invalid endpoint"));
        }

        // How do we decide what is the response content-type? 
        switch($this->request->headers['Accept']) {  // Making sure we know what the client wants -> we are generalizing/assuming that we know that we know what the client wants back(Accept)
            case "application/json":
                // Serialize the array of objects into a JSON array
                $payload = json_encode($rawpayload);
                $contenttype = "application/json";
                break;
                        
            case "application/xml":
                break;
            default:
                $payload = $rawpayload;
                $contenttype = "text/plain";
        }
        //set up the headerfields that will be sent to the response builder
        $headerfields = ['Status-Code' => $statuscode, 'Status-Text' => $statustext, 'Content-Type' => $contenttype];
// echo $payload; testing purpose
        // build the headerfields array that will be pass to the ResponseBuilder -> put all the data in the header array 
        
        $responseBuilder = new ResponseBuilder($headerfields, $payload);
        $this->response = $responseBuilder->getResponse(); // which resturns a response objct

    }

}// API Class closing bracket

// call the API class
$api = new API();
$api->processRequest();
echo $api->response->payload;


// Dependency injection

// loosely coupled by
//  $request = new Request(); // put this request inside
//  $this->request = $requestBuilder->getRequest(request); 

?>

<!--When we implement authentication the first thing is authenthication URL firsst and then the resource URL call is called-->