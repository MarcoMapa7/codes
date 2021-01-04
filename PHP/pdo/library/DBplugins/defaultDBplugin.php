<?php
/*
function Sql(){
$argv = func_get_args();
$sql = array(
'Lock'=>"LOCK TABLE $argv[1] $argv[2]"
);
return $sql[$argv[0]];
}
*/

use \Library\SystemException as SystemException;

class defaultDBplugin {
    public function __construct($data)
    {
        try {
            $this->data = $data;
            if ($user === NULL || $pass === NULL) {
                throw new SystemException('User and Password not filed.');
            }
            $this->db = new \PDO($this->data['type'].':host=' . $this->data['host'] . ';dbname=' . $this->data['database'], $this->data['user'], $this->data['pass']);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            $err = $this->db->errorInfo();
            if($err[0]>0){
                throw new SystemException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
            }
            
        } catch (\PDOException $e){
            //handle \PDO
            throw new SystemException( $e->getMessage( ) , (int)$e->getCode( ) );
        }
        
    }
    
    public function Sql(){
        $args = func_get_args();
        $sql = @array(
        'Lock'=>"LOCK TABLE ${args[1]} ${args[2]};",
        'UnLock' => "UNLOCK TABLES;",
        'isLock' => "SHOW OPEN TABLES  WHERE `Table` LIKE '%".$args[1]."%' AND  `Database` LIKE '%".$this->data['database']."%' AND In_use > 0 OR Name_locked > 0;",
        'SBegin' => "BEGIN; SAVEPOINT ${args[1]};",
        'SCommit' => "COMMIT;",
        'SRelease' => "RELEASE ${args[1]};",
        'SRollback' => "ROLLBACK TO ${args[1]};",
        'Begin' => "BEGIN;",
        'Commit' => "COMMIT;",
        'Release' => "RELEASE;",
        'Rollback' => "ROLLBACK;",
        'createTable' => "CREATE TABLE IF NOT EXISTS ".$args[1]." (".
        $args[2].
        ");",
        'createTableid' => "CREATE TABLE IF NOT EXISTS ${args[1]} (".
        "id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,".
        $args[2].
        ");",
        'dropTable' => "DROP TABLE IF EXISTS ".$args[1].";",
        'listTables' => "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='dbName';",
        'createTableRotate' => ""
        );
        return $sql[$args[0]];
    }
}


?>