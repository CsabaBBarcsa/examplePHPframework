<?php

namespace Examp\Core\Middleware;

use Examp\Core\Request\Request;
use Examp\Core\Response\Response;
use Examp\Core\Session\Session;
use Examp\Contracts\Middleware;

/**
 * Description of AuthenticationMiddleware
 */
class AuthenticationMiddleware implements Middleware
{
    private $protectedLinks;

    public function __construct(array $protectedLinks)
    {
        $this->protectedLinks = $protectedLinks;
    }

    /**
     * @desc - The authentication layer in the middlewares
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return object
     */
    public function process(Request $request, Response $response, callable $next)
    {
        // the middleware actions

        $checkUri = array_filter($this->protectedLinks, function($uri) use ($request)
        {
            return preg_match('%/'.$uri.'%', $request->getUri());
        });

        if( !empty($checkUri) && !$this->isLogged( $request->getSession() ) )
        {
            return $response->redirect('/');
        }

        // a "before" request
        return $next($request, $response);
    }

    /**
     * @desc - Checking the session if user is logged in
     * @param Session $session
     * @return bool
     */
    public function isLogged(Session $session): bool
    {
        return $session->has('logged');
    }

}
