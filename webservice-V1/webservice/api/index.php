<?php

    require(dirname(__DIR__)."/core/http/requestbuilder.php");
    require(dirname(__DIR__)."/core/http/responsebuilder.php");

    //request.php is already required by requestbuilder.php thus here we put "require_once" instead of "require"
    require_once(dirname(__DIR__)."/core/http/request.php");

    require_once(dirname(__DIR__)."/core/http/response.php");

    // Not a final code, we will have to revise this to generalize it.
    require(dirname(__DIR__)."/controllers/videoconversioncontroller.php");


    // The job of this class:
    // To process the HTTP Request URL 
    // and select the appropriate controller
    // instantiate the controller and then call its specific function
    //Then once the controller gets the data from the model
    // this class would build and return an HTTP Response
    class API{

        // Instead of building the request here, we encapsulate the request code in separate classes
        private $request;

        public $response;

        private $controller;

        function __construct()
        {
            
        }

        function processRequest(){

            $requestBuilder = new RequestBuilder();

            $this->request = $requestBuilder->getRequest();

            // To be revised
            $this->controller = new VideoConversionController();

            // Determine which controller function to call based on the request method
            switch ($this->request->method){

                case 'GET': 
                    // what paramters whould we pass? Where do we get it from?
                    //--- We need the apikey to identify the specific client we are getting the video conversions of
                    // What data should we expect and where to store it?
                   // $controller->list($apikey);

                    $this->processResponse();

                    break;
                case 'POST':
                    break;
                case 'PUT':
                    break;
                case 'DELETE':
                    break;
                case 'HEAD':
                    break;
                case 'OPTIONS':
                    break;

            }



        }

        function processResponse(){

                    // Read the API key sent by the client
                    $apikey = $this->request->urlparams['apikey'];

                    // Determine the reponse properties
                        $header = array();
                        $payload = array();
                        $statuscode = 0;
                        $statustext = "";
                        $contenttype = "";

                        // Get the data/resource
                        $rawpayload = $this->controller->list($apikey);

                        // Check if data  was returned: the data here is the requested resource
                        // If the data is found and can be returned
                        // The HTTP status code of the response should be: 200
                        if(count($rawpayload) > 0){
    
                            $statucode = 200;
                            $statustext = "OK";
    
                        }else{
    
                            $statuscode = 404;
                            $statustext = "Not Found";
    
                            $rawpayload = array('message' => "Possibly invalid enpoint.");
    
                        }
    
                        // How do we decide what is the response content-type?
                        switch($this->request->header['Accept']){
    
                            case 'application/json':
                                                    // Serialize the array of objects into a JSON array
                                                    $payload = json_encode($rawpayload);
                                                    $contenttype = 'application/json';
                                break;
                            case 'application/xml':
                                break;
                            default:
                                                    $payload = json_encode($rawpayload);
                                                    $contenttype = 'application/json';                               
                        }

                        $headerfields = ['Status-Code'=> $statucode, 'Status-Text' => $statustext, 'Content-Type' => $contenttype ];

                        $responseBuilder  = new Responsebuilder($headerfields, $payload);

                        $this->response = $responseBuilder->getResponse();
        }


    }// API class

    $api = new API();

    $api->processRequest();

    echo( $api->response->payload);

?>