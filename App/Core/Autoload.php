<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 01.01.2017
 * Time: 23:25
 */

function autoload($className) {
    $className = ltrim($className, '\\');
    $fileName = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    //echo "<br>" . $fileName;
    require $fileName;
}

spl_autoload_register('autoload');