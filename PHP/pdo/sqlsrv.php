<?php

/*
* is simple connector helper with few most used functions
*/

require("Library/DB.php");

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOT')) {
    define('ROOT', realpath(dirname(__FILE__)));
}

$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' . dirname($_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']) 
        . '/' : 'http://' 
        . dirname($_SERVER['HTTP_HOST'] 
        . $_SERVER['SCRIPT_NAME']) 
        . '/';

if (!defined('HOST')) {
    define('HOST', $url);
}

$d = new \Library\DB;

// for sqlite "localhost" can be relaced with path to database
$d->Connect('sqlsrv','erotika','erotika','etk#98x1aqf','sqlserver01.kplay.com.br,51100');


$result = $d->Query('select top 1 nome from view_consultor'); // like prepare, exec is shotrcut to PDO fn

echo json_encode($result);    
?>