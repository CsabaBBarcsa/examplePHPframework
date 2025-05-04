<?php

use Examp\Core\Containers\ServiceContainer;

use Examp\Core\Database;
use Examp\Core\Dispatcher;
use Examp\Core\Handlers\Input\InputsManager;
use Examp\Core\Middleware\AuthenticationMiddleware;
use Examp\Core\Middleware\CleanupFlashMiddleware;
use Examp\Core\Middleware\DispatcherMiddleware;
use Examp\Core\MiddlewarePipeline;
use Examp\Core\Request\Request;
use Examp\Core\Request\RequestFactory;
use Examp\Core\Response\ResponseEmitter;
use Examp\Core\Response\ResponseFactory;
use Examp\Core\Session\Session;
use Examp\Core\View\ViewRenderer;
use Examp\Core\Url;

use App\Services\LoginSubmitService;

use App\Controllers\HomeController;
use App\Controllers\MermberController;
use App\Controllers\NotFoundController;
use App\Controllers\LoginFormController;
use App\Controllers\LoginSubmitController;

return [
    
    Url::class => function()
    {
        return new Url();
    },
    Session::class => function ()
    {
        return new Session();
    },
    Database::class => function( ServiceContainer $container )
    {
        $config = $container->get('config');
        return new Database($config);
    },
    ViewRenderer::class => function( ServiceContainer $container )
    {
        $config = $container->get('config');
        return new ViewRenderer( $config->get('basePath') );
    },
    Request::class => function( ServiceContainer $container )
    {
        // it gives back the Request class
        return (new RequestFactory($container))->createRequest();
    },
    ResponseFactory::class => function( ServiceContainer $container )
    {
        return new ResponseFactory($container->get(ViewRenderer::class));
    },
    Dispatcher::class => function( ServiceContainer $container )
    {
        $dispatcher = new Dispatcher('notFoundCtrl',$container);
        
        $dispatcher->addRoute('/', 'homeCtrl');
        $dispatcher->addRoute('/login', 'loginFormCtrl');
        $dispatcher->addRoute('/login/trylogin', 'loginSubmitCtrl:::submit', 'post');
        $dispatcher->addRoute('/logout', 'loginSubmitCtrl:::logout');
        $dispatcher->addRoute('/protected', 'mermberCtrl');
        
        return $dispatcher;
    },
    MiddlewarePipeline::class => function( ServiceContainer $container )
    {
        $authenticationPipe = new AuthenticationMiddleware( ['protected'] );
        $cleanupFlashPipe = new CleanupFlashMiddleware( );
        $dispatcherPipe = new DispatcherMiddleware( $container->get(Dispatcher::class), $container->get(ResponseFactory::class) );
        
        $pipeline = new MiddlewarePipeline();
        
        $pipeline->addPipe($authenticationPipe);
        $pipeline->addPipe($cleanupFlashPipe);
        $pipeline->addPipe($dispatcherPipe);
        
        return $pipeline;
    },
    ResponseEmitter::class => function()
    {
        return new ResponseEmitter();
    }, 
    InputsManager::class => function ( ServiceContainer $container )
    {
        return new InputsManager( $container->get(Request::class) );
    },
            
    LoginSubmitService::class => function( ServiceContainer $container )
    {
        return new LoginSubmitService( $container->get(Database::class), $container->get(Session::class) );
    },
            
    'notFoundCtrl' => function()
    {
        return new NotFoundController();
    },
    'homeCtrl' => function()
    {
        return new HomeController();
    },
    'mermberCtrl' => function()
    {
        return new MermberController();
    },
    'loginFormCtrl' => function(ServiceContainer $container)
    {
        return new LoginFormController( $container );  
    },
    'loginSubmitCtrl' => function( ServiceContainer $container )
    {
        return new LoginSubmitController( $container );
    },
];