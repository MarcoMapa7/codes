<?php
class Config {
	public static $dbHost = 'localhost';
	public static $dbPassword = '';
	public static $dbName = 'crud';
	public static $dbUser ='root';
	public static $dbCharset = 'utf8';
	public static $pdoVerbose	=false; // show pdo errors
	public static $phpErrorMode = E_ALL; //
	public static $appName = "CRUD360"; //
	public static $appTitle = "Crud360 - Painless Admin Panel Setup!"; //
	

}
// Turn off all error reporting $phpErrorMode = 0
// Report simple running errors $phpErrorMode = E_ERROR | E_WARNING | E_PARSE
// Reporting E_NOTICE can be good too (to report uninitialized variables or catch variable name misspellings ...) $phpErrorMode = E_ERROR | E_WARNING | E_PARSE | E_NOTICE
// Report all errors except E_NOTICE $phpErrorMode = E_ALL & ~E_NOTICE;
// Report all PHP errors $phpErrorMode = E_ALL;
// Report all PHP errors $phpErrorMode =-1;
?>
