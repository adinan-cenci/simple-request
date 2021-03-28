<?php 
namespace AdinanCenci\SimpleRequest;

class Response 
{
    protected $url;
    protected $code;
    protected $header;
    protected $body;
    protected $errorCode;
    protected $errorMessage;

    public function __construct($url, $code, $header, $body, $errorCode, $errorMessage) 
    {
        $this->url          = $url;
        $this->code         = $code;
        $this->header       = $header;
        $this->body         = $body;
        $this->errorCode    = $errorCode;
        $this->errorMessage = $errorMessage;
    }

    public function __get($var) 
    {
        return $this->{$var};
    }
}
