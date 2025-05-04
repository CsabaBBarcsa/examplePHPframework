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

if(file_exists(SUPPORTPATH.DS.'services.php'))
{
    $services = require_once SUPPORTPATH.DS.'services.php';
}
if(file_exists(SUPPORTPATH.DS.'configs.php'))
{
    $configs = require_once SUPPORTPATH.DS.'configs.php';
}

Application::init()->run( $configs, new ServiceContainer($services));