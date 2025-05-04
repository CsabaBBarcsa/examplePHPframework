<?php

namespace Examp\Contracts;

/**
 */
interface Session {
   
    public function has(string $key);
    
    public function get(string $key);
    
    public function getAll();
    
    public function add(string $key, $value);
    
    public function remove(string $key);
    
    public function clearAll();
        
}
