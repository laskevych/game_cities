<?php
require_once 'database.php';
//Отказался от реализации
class temp_table extends DB
{
    private $q;
    private $res;
    public function createTable()
    {
        //$this->q = "SHOW TABLES FROM homework LIKE 'temp";
        $this->q = "CREATE TABLE temp (`id_cities` INT(11) NOT NULL)";
        $this->query($this->q);
        //$this->q = "CREATE TABLE temp (`id_cities` INT(11) NOT NULL)";
        //$this->query($this->q);
    }

}

/*$q = "CREATE TABLE temp (`id_cities` INT(11) NOT NULL)";
                    $obj1->query($q);
                    $q = "INSERT INTO temp (id_cities) VALUES('".$res[0][id]."')";
                    $obj1->query($q);*/


/*
 * CREATE TABLE `temp` (`id_cities` INT(11) NOT NULL);
 *CREATE TABLE `best` (`id_cities` INT(11) NOT NULL);
 * INSERT INTO users (login, password) VALUES('".$login."','".$token."')
 *
 */