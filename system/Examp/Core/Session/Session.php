<?php

namespace Examp\Core\Session;

use Examp\Core\Session\Flash;
use Examp\Contracts\Session as SessionInterface;

class Session implements SessionInterface
{                   
    public function has(string $key)
    {
        return array_key_exists($key, $_SESSION);
    }
    
    public function get(string $key) 
    {
        if($this->has($key))
        {
            return $_SESSION[$key];
        }
        return [];
    }

    public function getAll() 
    {
        return $_SESSION;
    }
    
    public function add(string $key, $value) 
    {
        $_SESSION[$key] = $value;
    }
    
    public function remove(string $key) 
    {
        unset($_SESSION[$key]);
    }

    public function clearAll() 
    {
        session_destroy();
    }
    
    public function flash()
    {
        return new Flash($this);
    }
    
}