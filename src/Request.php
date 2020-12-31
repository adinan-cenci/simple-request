<?php 
namespace AdinanCenci\SimpleRequest;

class Request 
{
    protected $url          = null;
    protected $method       = 'GET';
    protected $headers      = null;
    protected $fields       = array();

    public function __construct($url) 
    {
        $this->url = $url;
    }

    public function headers($headers) 
    {
        $this->headers = $headers;
        return $this;
    }

    public function addHeaders($headers) 
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    public function fields($array) 
    {
        $this->fields = $array;
        return $this;
    }

    public function addFields($array) 
    {
        $this->fields = array_merge($this->fields, $array);
        return $this;
    }

    public function post() 
    {
        $this->method('POST');
        return $this;
    }

    public function get() 
    {
        $this->method('GET');
        return $this;
    }

    public function method($type) 
    {
        $this->method = $type;
        return $this;
    }
    
    public function request() 
    {
        $options    = $this->getCurlOptions();
        $ch         = curl_init();
        curl_setopt_array($ch, $options);
        $response   = curl_exec($ch);
        $httpCode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header     = substr($response, 0, $headerSize);
        $body       = substr($response, $headerSize);

        curl_close($ch);

        //--------------

        return new Response($httpCode, $header, $body);
    }

    protected function getCurlOptions() 
    {
        $options = array(
            CURLOPT_URL             => $this->url, 
            CURLOPT_SSL_VERIFYPEER  => false, // don't verify certificate
            CURLOPT_FOLLOWLOCATION  => true,  // follow redirects
            CURLOPT_RETURNTRANSFER  => true,  // return content
            CURLOPT_HEADER          => true   // return headers
        );

        if ($this->headers) {
            $options[CURLOPT_HTTPHEADER] = $this->headers;
        }

        if ($this->method == 'POST') {
            $options[CURLOPT_POST] = true;
        }

        if ($this->method == 'POST' && $this->fields) {
            $options[CURLOPT_POSTFIELDS] = $this->fields;
        }

        if ($this->method == 'GET' && $this->fields) {
            $options[CURLOPT_URL] = Helper::urlAddToQuery($options[CURLOPT_URL], $this->fields);
        }

        return $options;
    }
}
