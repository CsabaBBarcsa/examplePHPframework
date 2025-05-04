<?php

namespace Examp\Core\Middleware;

use Examp\Core\Controller;
use Examp\Core\Request\Request;
use Examp\Core\Response\Response;
use Examp\Core\Response\ResponseFactory;
use Examp\Core\Dispatcher;
use Examp\Contracts\Middleware;

use Exception;

/**
 * Description of DispatcherMiddleware
 */
class DispatcherMiddleware implements Middleware
{
    private $dispatcher;
    private $resonseFactory;

    public function __construct( Dispatcher $dispatcher, ResponseFactory $resonseFactory)
    {
        $this->dispatcher = $dispatcher;
        $this->resonseFactory = $resonseFactory;
    }

    /**
     * @desc - That makes the last layer of the pipe which is belongs to the Dispatcher
     *         And to create a response through ResponseFactory
     *       - This Middleware is the last of the middleware pipeline
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return type
     * @throws Response|Exception
     */
    public function process( Request $request, Response $response, callable $next)
    {
        // middleware action

        $controllerResponse = $this->dispatcher->dispatch($request);

        if (!$controllerResponse instanceof Controller)
        {
            throw new Exception('Missing instance: ' . Controller::class);
        }

        // the last respone of the pipeline
        
        return $this->resonseFactory->createResponse($controllerResponse, $request, $response);
    }

}
