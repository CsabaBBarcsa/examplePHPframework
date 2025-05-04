<?php

function autoloadSystemClasses($className)
{
    $prefix = 'Examp';
    $ds = DIRECTORY_SEPARATOR;
    $systemPath = dirname(dirname(__DIR__));
    
    if (substr($className, 0, strlen($prefix)) !== $prefix) 
    {
        return;
    }
    
    $classPath = strtr( $systemPath . $ds . $className . '.php', '/\\', $ds.$ds);

    if(file_exists($classPath))
    {
        include_once $classPath;
    }
}
spl_autoload_register('autoloadSystemClasses');


function autoloadAppClasses($className)
{
    $prefix = 'App';
    $ds = DIRECTORY_SEPARATOR;
    $baseDir = dirname(dirname(dirname(__DIR__)));
    
    if (substr($className, 0, strlen($prefix)) !== $prefix)
    {
        return;
    }
    
    $classPath = strtr( $baseDir . $ds . lcfirst($className) . '.php', '/\\', $ds.$ds);

    if(file_exists($classPath))
    {
        include_once $classPath;
    }
}
spl_autoload_register('autoloadAppClasses');