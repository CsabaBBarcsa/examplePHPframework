<?php

namespace Examp\Contracts;

/**
 * @desc This interface has three method for the cotainer functionality
 */
interface Containers {
    
    public function has(string $key);
    
    public function get(string $key);
    
    public function add(string $key, $value);
        
}
