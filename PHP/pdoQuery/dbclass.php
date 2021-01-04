<?php
// Database functions
class Db
{
    protected $conn;

    public function __construct()
    {
        $config = array('DB_USERNAME' => 'root', 'DB_PASSWORD' => '');

        try
        {
            $this->conn = new PDO('mysql:host=localhost;dbname=church_web', $config['DB_USERNAME'],
                $config['DB_PASSWORD']);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }
        catch (PDOException $e)
        {
            die("<font color='red'>Status: Connection to Database Failed!</font>");
            return false;
        }
    }

    public function db_query($query)
    {
        try
        {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results ? $results : false;
        }
        catch (exception $e)
        {
            return false;
        }
    }


    public function query($query, $bindings)
    {
        try
        {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($bindings);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results ? $results : false;
        }
        catch (exception $e)
        {
            return false;
        }
    }

    public function count_query($query, $bindings)
    {
        try
        {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($bindings);
            $results = $stmt->rowCount();
            return $results ? $results : false;
        }
        catch (exception $e)
        {
            return false;
        }
    }


    public function db_get($tablename, $limit = 10)
    {
        try
        {
            $res_get = $this->conn->query("SELECT * FROM $tablename LIMIT $limit");
            $results = $res_get->fetchAll(PDO::FETCH_ASSOC);
            return $results ? $results : false;
        }
        catch (exception $e)
        {
            return false;
        }
    }


    public function db_inner_join($tablename1, $tablename2, $tablename2_id, $tablename1_id)
    {
        try
        {
            $res_inner = $this->conn->query("SELECT * FROM $tablename1 INNER JOIN $tablename2 
        ON $tablename2_id = $tablename1_id");
            return ($res_inner->rowCount() > 0) ? $res_inner : false;
        }
        catch (exception $e)
        {
            return false;
        }
    }

}