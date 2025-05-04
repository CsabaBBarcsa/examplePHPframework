<?php

namespace Examp\Core\Request;

use Examp\Core\Url;
use Examp\Core\Session\Session;
/**
 * Description of Request
 */
class Request
{    
    private $uri;
    private $method;
    private $header;
    private $body;
    private $session;
    private $cookie;
    private $reqestedParams;
    
    public function __construct( Url $uri, string $method, array $header, $body, Session $session, $cookie, array $reqestedParams)
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->header = $header;
        $this->body = $body;
        $this->session = $session;
        $this->cookie = $cookie;
        $this->reqestedParams = $reqestedParams;
    }

    public function getUri() 
    {
        return $this->uri->getFullUri();
    }
    
    public function getBaseUrl()
    {
        return $this->uri->getBaseUrl();
    }

    public function getMethod() 
    {
        return $this->method;
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    public function getCookie() 
    {
        return $this->cookie;
    }

    public function getReqestedParams()
    {
        return $this->reqestedParams;
    }
   
}
