<?php
// Set your database name, database user, database password and database name in actual class file in
// crud360/includes/class.config.php
class Config {
	public static $dbHost = 'localhost'; 	//your database host, usually localhost
	public static $dbPassword = '';			//your mysql database password
	public static $dbName = 'crud360';		//your mysql database name
	public static $dbUser ='root';			//your database user name
	public static $dbCharset = 'utf8';  	//database charset, usually utf8
	public static $pdoVerbose	=false; 	//show pdo errors
}
?>