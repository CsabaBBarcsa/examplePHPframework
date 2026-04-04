<?php
namespace Examp\Core;

use Examp\Core\Containers\ServiceContainer;
use Examp\Core\Request\Request;
use Exception;

/**
 * Description of Dispatcher
 */
class Dispatcher
{
    const METHOD_DIVIDER = ':::';
    
    private $routes = [];
    private $notFoundController;
    private $services;
    
    public function __construct(string $notFoundController, ServiceContainer $services)
    {
        $this->notFoundController = $notFoundController;
        $this->services = $services;
    }
    
    /**/
    public function addRoute(string $action, string $calling, string $method = 'GET')
    {
        $actionPattern = '%^'.$action.'$%';
        $this->routes[strtoupper($method)][$actionPattern] = $calling;
    }
    
    /**/
    public function dispatch( Request $request)
    {
        $uri = $request->getUri();
        $method = $request->getMethod();
        
        if(array_key_exists($method, $this->routes))
        {
            foreach($this->routes[$method] as $actionPattern => $calling)
            {
                if(preg_match($actionPattern, $uri, $matches))
                {
                    return $this->invokeHandler($calling, $matches);
                }
            }
        }
        return $this->invokeHandler($this->notFoundController);
    }
    
    /**/
    protected function invokeHandler(string $called, $matchedParams = FALSE)
    {        
        $splittedCall = explode(self::METHOD_DIVIDER, $called);
        $controllerNameAlias = $splittedCall[0];
        $methodName = $splittedCall[1] ?? NULL;
        
        return $this->invokeController($controllerNameAlias, $methodName, $matchedParams);
    }
    
    /**/
    protected function invokeController($controllerNameAlias, $methodName, $matchedParams)
    {
        $calledControllerObj = $this->services->get($controllerNameAlias);
        $calledMethodName = !empty($methodName) ? $methodName : 'index';

        if(is_object($calledControllerObj) && method_exists($calledControllerObj, $calledMethodName) )
        {
            return $calledControllerObj->$calledMethodName($matchedParams);
        }
        
        $methodNameMarked = !empty($methodName) ? " -- ".$methodName." -- " : '';
        throw new Exception("The controller is not an object or, has not the called method".$methodNameMarked.", or has not index method!");
    }
    
}
