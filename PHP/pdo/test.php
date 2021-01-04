<?php

/*
* is simple connector helper with few most used functions
*/

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOT')) {
    define('ROOT', realpath(dirname(__FILE__)));
}

$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' . dirname($_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']) . '/' : 'http://' . dirname($_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']) . '/';
if (!defined('HOST')) {
    define('HOST', $url);
}
 
        $d = new \Library\DB;
        // for sqlite "localhost" can be relaced with path to database
        $d->Connect('mysql','database','user','pass','localhost');

        var_dump($d->db); // << PDO Object
        $d->db->query(SQL); // call PDO fn

        $d->createTable('tested',array(
            'name VARCHAR(255)',
            'string VARCHAR(255)'

        ));

        $d->TInsertIF('tested',['name'=>'info','string'=>'text']);
        // same as
        $d->Begin();
        $d->InsertIF('tested',['name'=>'info','string'=>'text']);
        $->Commit(); // or $d->Rollback(); on error

        $d->Tupdate('tested',['string'=>'changed'],'where name=?',['info']);

        $d->Tinsertupdate('tested',['string'=>'other'],'where name=?',['none']); // insert if not found or update exists

        $d->Select('tested', ['*'], 'WHERE name = ?', ['info']);

        $d->Query(SQL Query); // like prepare, exec is shotrcut to PDO fn

        $d->dropTable('tested');
?>