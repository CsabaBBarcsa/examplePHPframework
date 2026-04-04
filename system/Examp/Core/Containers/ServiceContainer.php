<?php
namespace Examp\Core\Containers;

use Examp\Contracts\Containers;
use Exception;

/**
 * Description of ServiceContainer
 */
class ServiceContainer implements Containers{

    private $services;

    public function __construct(array $services)
    {
        $this->services = $services;
    }

    public function has(string $key)
    {
        return array_key_exists($key, $this->services);
    }

    public function add(string $key, $value)
    {
        if ( $this->has($key) )
        {
            throw new Exception('The service under this key ('.$key.') is already exists!');
        }

        if ( !is_callable($value) && !is_object($value) )
        {
            throw new Exception('The service is must be a function or an object!');
        }

        $this->services[$key] = $value;
    }

    public function get(string $key)
    {
        if ( $this->has($key) )
        {
            $service = $this->services[$key];
            if ( is_callable($service) )
            {
                $this->services[$key] = $service = $service($this);
            }
            return $service;
        }
        else
        {
            throw new Exception('There is no service under this key: '.$key.'!');
        }
    }

}
