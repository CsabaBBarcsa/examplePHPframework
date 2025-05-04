<?php

namespace Examp\Contracts;

use Examp\Core\Response\Response;
use Examp\Core\Request\Request;
/**
 */
interface Middleware {

    public function process( Request $request, Response $response, callable $next);
    
}
