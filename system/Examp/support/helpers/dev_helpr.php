<?php

/* 
 * some functions for development
 */

if(!function_exists('vdx'))
{
    function vdx($mixd)
    {
        echo"<pre>";
        var_dump($mixd);
        echo"</pre>";
    }
}

if(!function_exists('dd'))
{
    function dd($mixd)
    {
        echo"<pre>";
        var_dump($mixd);
        echo"</pre>";
        die();
    }
}

//if(!function_exists('getExistedFile'))
//{
//    function getExistedFile($filePath)
//    {
//        if(file_exists($filePath))
//        {
//            return include_once $filePath;
//        }
//        else
//        {
//            return FALSE;
//        }
//    }
//}