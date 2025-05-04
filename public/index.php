<?php
declare (strict_types = 1);

session_start();

define('ISRUN', microtime());


$environment =
        [
            'prod'    => 'production',
            'staging' => 'online-test',
            'dev'     => 'development'
        ];

define('ENV', $environment['dev']);

if (ENV === 'development')
{
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

defined('DS') OR define('DS', DIRECTORY_SEPARATOR);

defined('BASEPATH') OR define('BASEPATH', dirname(__DIR__));
defined('SYSPATH') OR define('SYSPATH', BASEPATH . DS . 'system');

if (file_exists(SYSPATH.DS.'sys.php'))
{
    defined('EXAMPLEPATH') OR define('EXAMPLEPATH', SYSPATH . DS . 'Examp');
    defined('SUPPORTPATH') OR define('SUPPORTPATH', EXAMPLEPATH . DS . 'support');

    if(ENV === 'development' && file_exists(SUPPORTPATH . DS . 'helpers' . DS . 'dev_helpr.php'))
    {
        require_once SUPPORTPATH . DS . 'helpers' . DS . 'dev_helpr.php';
    }

    if(file_exists(SUPPORTPATH . DS . 'autoloaders.php'))
    {
        require_once SUPPORTPATH . DS . 'autoloaders.php';
    }

    require_once SYSPATH . DS . 'sys.php';
}
else
{
    header('HTTP/1.1 503 Service Unavailable', true, 503);
    die();
}