<?php

namespace Examp\Contracts;

/**
 *
 */
interface Containers {
    
    public function has(string $key);
    
    public function get(string $key);
    
    public function add(string $key, $value);
        
}
