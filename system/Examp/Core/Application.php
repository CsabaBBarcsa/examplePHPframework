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
     
/* maje the class singleton */   
    private function __construct(){}
    
    /* initialize the singelton object */
    public static function init()
    {
        if ( self::$instance === null )
        {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /* it runs the hole application */
    public function run( ConfigContainer $config ,ServiceContainer $serviceContainer)
    {
        try
        {  
            $serviceContainer->add('config', $config);

            /* making the response through the middleware pipline */
            $response = $serviceContainer
                ->get(MiddlewarePipeline::class)
                ->pipeline( $serviceContainer->get(Request::class), new Response([], '', 200, 'Ok'));
            
 /* emitting the response that was finished before */           $serviceContainer->get(ResponseEmitter::class)->emit($response);
        }
        catch(\Exception $errorReport)
        {
            echo 'Something went wrong: ';
            print_r($errorReport->getMessage());
            die();
        }
    }

}