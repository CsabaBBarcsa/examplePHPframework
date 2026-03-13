<?php
defined('ISRUN') OR exit('Direct access to the script not allowed!');

use Examp\Core\Application;
use Examp\Core\Containers\ServiceContainer;
use Examp\Core\Containers\ConfigContainer;

/**
 * @type array
 */
$services = null;
/**
 * @var ConfigContainer $configs
 */
$configs = null;

/* if file exists, it will gives back an array of services */
if(file_exists(SUPPORTPATH.DS.'services.php'))
{
    $services = require_once SUPPORTPATH.DS.'services.php';
}
/* if file exists, it will gives back the object of Configs class, that holds several options : ....*/
if(file_exists(SUPPORTPATH.DS.'configs.php'))
{
    $configs = require_once SUPPORTPATH.DS.'configs.php';
}

/* starting the application with a singleton */
Application::init()->run( $configs, new ServiceContainer($services));