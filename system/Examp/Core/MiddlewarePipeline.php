<?php
namespace Examp\Core;

use Examp\Contracts\Middleware;
use Examp\Core\Response\Response;
use Examp\Core\Request\Request;

/**
 * Description of MiddlewarePipeline
 */
class MiddlewarePipeline
{
    /**
     * @desc - store the middlewares
     * @var array
     */
    private $pipes = [];

    /**
     * @desc - adding a middleware in the pipeline
     * @param Middleware $pipe
     */
    public function addPipe( Middleware $pipe)
    {
        $this->pipes[] = $pipe;
    }

    /**
     * @desc - bind middleware layers into a line
     * @param Request $request
     * @param Response $response
     * @return object
     */
    public function pipeline( Request $request, Response $response)
    {
        return $this->__invoke($request, $response);
    }

    /**
     * @desc - it's called when the class called like a function
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke( Request $request, Response $response )
    {
        $pipe = array_shift($this->pipes);
        if($pipe === NULL)
        {
            return $response;
        }
        return $pipe->process($request, $response, $this);
    }

}
