<?php 
namespace AdinanCenci\SimpleRequest;

class Response 
{
    protected $url;
    protected $code;
    protected $header;
    protected $body;

    public function __construct($url, $code, $header, $body) 
    {
        $this->url      = $url;
        $this->code     = $code;
        $this->header   = $header;
        $this->body     = $body;
    }

    public function __get($var) 
    {
        return $this->{$var};
    }
}
