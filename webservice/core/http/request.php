<?php
// A class that represents an HTTP request

// We could make the request object immutable
class Request {
    public readonly string $method;
    public readonly array $urlparams;
    public readonly array $headers;
    public readonly array $payload; //data

    function __construct($method, $urlparams, $headers, $payload) {
        $this->method = $method;
        $this->urlparams = $urlparams;
        $this->headers = $headers;
        $this->payload = $payload;
    }

    // We could implement Getters
    // but don't implement setters because this object is supposed to be immutable
}   
?>