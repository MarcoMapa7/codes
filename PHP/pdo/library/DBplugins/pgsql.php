<?php

use \Library\SystemException as SystemException;

class pgsql {
    public function __construct($data)
    {
        try {
            $this->data = $data;
            if ($this->data['user'] === NULL || $this->data['pass'] === NULL) {
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
        'isLock' => "PRAGMA lock_status;",
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
        'createTableid' => "CREATE SEQUENCE ".$args[1]."_id_seq;".
        "CREATE TABLE IF NOT EXISTS ".$args[1]." (".
        "id INTEGER NOT NULL PRIMARY KEY,".
        $args[2].
        ");".
        "ALTER TABLE ${args[1]} ALTER id SET DEFAULT NEXTVAL('".$args[1]."_id_seq');",
        'dropTable' => "DROP TABLE IF EXISTS ".$args[1].";",
        'listTables' => "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public';",
        'createTableRotate' => ""
        );
        return $sql[$args[0]];
    }
}


?>