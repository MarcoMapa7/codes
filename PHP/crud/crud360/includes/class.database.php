<?php

include_once("class.config.php");
//=========== PDO connection encapsulation
class DB360 {
	public $PDO;
	public function __construct ()
	{
		$dsn = "mysql:host=".Config::$dbHost.";dbname=".Config::$dbName.";charset=".Config::$dbCharset;
		$opt = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH,
			PDO::ATTR_EMULATE_PREPARES   => false,
			
		];
		try {
			$this->PDO = new PDO($dsn, Config::$dbUser, Config::$dbPassword, $opt);
		} 
		catch (PDOException $e) {
				$this->PDO = "";
				echo $e->getMessage();
				exit(0);
		}
	}
	public function SELECT($sql,$where,$values=array())
	{
		//values must be a keyed array, sql must have named placeholders corresponding to the keyed values
		$s = "";
		$sql.=$where;
		
		try {
		$s = $this->PDO->prepare(($sql));
		if(is_array($values))
			$s->execute($values);
		else
			$s->execute();
		$rows = $s->fetchAll();
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
			return false;
		}
		return $rows;
	}

}
// Single Globally accesssible PDO object (to prevent reconnects)
$DB = new DB360();
?>