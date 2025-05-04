<?php
namespace Examp\Core;

defined('ISRUN') OR exit('Direct access to the script not allowed!');

use Examp\Core\Containers\ServiceContainer;
use Examp\Core\Containers\ConfigContainer;
use Examp\Core\Request\Request;
use Examp\Core\Response\Response;
use Examp\Core\Response\ResponseEmitter;
use Examp\Core\MiddlewarePipeline;

class Application 
{
    protected static $instance;
        
    private function __construct(){}
    
    /**/
    public static function init()
    {
        if ( self::$instance === null )
        {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**/
    public function run( ConfigContainer $config ,ServiceContainer $serviceContainer)
    {
        try
        {  
            $serviceContainer->add('config', $config);
            
            $response = $serviceContainer
                ->get(MiddlewarePipeline::class)
                ->pipeline( $serviceContainer->get(Request::class), new Response([], '', 200, 'Ok'));
            
            $serviceContainer->get(ResponseEmitter::class)->emit($response);
        }
        catch(\Exception $errorReport)
        {
            echo 'Something went wrong: ';
            print_r($errorReport->getMessage());
            die();
        }
    }

}