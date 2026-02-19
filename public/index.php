<?php
declare (strict_types = 1);

session_start();

define('ISRUN', microtime());

/* Environment modes for further options */
$environment =
        [
            'prod'    => 'production',
            'staging' => 'online-test',
            'dev'     => 'development'
        ];

/* Setting environment mode value */
define('ENV', $environment['dev']);

/* If development mode on, then show the errors */
if (ENV === 'development')
{
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

/* separator shortner */
defined('DS') OR define('DS', DIRECTORY_SEPARATOR);
/* some paths declaration */
defined('BASEPATH') OR define('BASEPATH', dirname(__DIR__));
defined('SYSPATH') OR define('SYSPATH', BASEPATH . DS . 'system');

/* checking system file */
if (file_exists(SYSPATH.DS.'sys.php'))
{
    /* some paths declaration */
defined('EXAMPLEPATH') OR define('EXAMPLEPATH', SYSPATH . DS . 'Examp');
    defined('SUPPORTPATH') OR define('SUPPORTPATH', EXAMPLEPATH . DS . 'support');

/* load dev. helper functions in dev. mode */
    if(ENV === 'development' && file_exists(SUPPORTPATH . DS . 'helpers' . DS . 'dev_helpr.php'))
    {
        require_once SUPPORTPATH . DS . 'helpers' . DS . 'dev_helpr.php';
    }

/* load the autoloader, that will autoloads the classes and interfaces */
    if(file_exists(SUPPORTPATH . DS . 'autoloaders.php'))
    {
        require_once SUPPORTPATH . DS . 'autoloaders.php';
    }

/* load the system file */
    require_once SYSPATH . DS . 'sys.php';
}
else
{
    header('HTTP/1.1 503 Service Unavailable', true, 503);
    die();
}