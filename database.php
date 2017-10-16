<?php
/**************************************
 * Работа с БД
 **************************************/
class DB
{
    private $db_login = 'root';
    private $db_pass = '';
    private $db_host = 'localhost';
    private $db_name = 'homework';
    private $mysqli;
    private $res;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        if (isset($this->mysqli))
        {
            return $this->mysqli;
        }
        else
        {
            $this->mysqli = new mysqli($this->db_host,$this->db_login,$this->db_pass,$this->db_name);
        }
    }

    public function query($query)
    {
        if (empty($query))
        {
            return false;
        }
        else
        {
            return $this->res = $this->mysqli->query($query);
        }

    }
    public function results()
    {
        //print_r($this->mysqli);
        $this->mysqli->errno;
        $this->mysqli->error;
        while ($res = $this->res->fetch_assoc()) {
            $results[] = $res;
        }
        return $results;
    }
    public function result() {

        return $this->res->fetch_assoc();
    }
}
?>