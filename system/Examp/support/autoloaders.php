<?php

/* @desc - it's loads the necessary system classes */
function autoloadSystemClasses($className)
{
    $prefix = 'Examp';
    $ds = DIRECTORY_SEPARATOR;
    $systemPath = dirname(dirname(__DIR__));
    
/* checking the prefix in the class namespace */
    if (substr($className, 0, strlen($prefix)) !== $prefix) 
    {
        return;
    }
    
/* fixing the file path to correct loading, that comes from the name space, and system path */
    $classPath = strtr( $systemPath . $ds . $className . '.php', '/\\', $ds.$ds);

/* loads the file of the class */
    if(file_exists($classPath))
    {
        include_once $classPath;
    }
}
spl_autoload_register('autoloadSystemClasses');

/* @desc - it's loads the necessary classes of the application */
function autoloadAppClasses($className)
{
    $prefix = 'App';
    $ds = DIRECTORY_SEPARATOR;
    $baseDir = dirname(dirname(dirname(__DIR__)));
    
/* checking the prefix in the class namespace */
    if (substr($className, 0, strlen($prefix)) !== $prefix)
    {
        return;
    }
    
/* fixing the file path to correct loading, that comes from the name space, and base directory path */
    $classPath = strtr( $baseDir . $ds . lcfirst($className) . '.php', '/\\', $ds.$ds);

/* loads the file of the class */
    if(file_exists($classPath))
    {
        include_once $classPath;
    }
}
spl_autoload_register('autoloadAppClasses');