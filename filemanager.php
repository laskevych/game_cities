<?php require_once 'database.php';
/**************************************
 * Файловый менеджер для загрузки списка городов
 **************************************/
class FileManager
{
    public $file;
    public $res;
    public $file_res;
    public $filename = 'files/cities.txt';
    static public $error; //Вывод ошибок в верстке. Не успел реализовать

    public function getOpenFile()
    {
        $this->file = file_get_contents("$this->filename");
        $this->res = explode("\r\n", $this->file);
    }

    public function getUploadFile()
    {
        for ($i = 0; $i < count($this->res); $i++) {
            $obj = new DB();
            $q = "INSERT INTO cities (city_name) VALUES('" . $this->res[$i] . "')";
            $obj->query($q);
            echo 'Done';
        }
    }

    /*******************************************************************************
     * Проверка на наличие таблицы с городами, ее последующие создание и заполнение
     * Не хватило времени реализовать
     *******************************************************************************/
    public function getCheck()
    {
        $check = new DB();
        $q = "SHOW TABLES LIKE 'cities'";
        $check->query($q);
        $res = $check->results();
        if (!$res) {
            $check = new DB();
            $q = "CREATE TABLE cities(id INT NOT NULL AUTO_INCREMENT, city_name VARCHAR(255) NOT NULL, PRIMARY KEY (id))";
            $check->query($q);
            $res = $check->results();
            $this->file = file_get_contents("$this->filename");
            $this->res = explode("\r\n", $this->file);
            for ($i = 0; $i < count($this->res); $i++) {
                $obj = new DB();
                $q = "INSERT INTO cities (city_name) VALUES('" . $this->res[$i] . "')";
                $obj->query($q);
                echo 'Done';
            }

            if (!$res) {
                echo 'таблицу не создал';
                //$this->getOpenFile();
                //$this->getUploadFile();
            }
        } else {
            echo 'создал и заполнил';
        }
    }


    public function addTablePlayers() //создание таблицы для списка лидеров
    {
        $check = new DB();
        $q = "SHOW TABLES LIKE 'players'";
        $check->query($q);
        $res = $check->result();
        if (!$res) {
            //$check = new DB;
            $q = "CREATE TABLE players(id INT NOT NULL AUTO_INCREMENT, player_name VARCHAR(255) NOT NULL, PRIMARY KEY (id))";
            $check->query($q);
            $res = $check->result();
            if (!$res) {
                echo 'table players not created';
            }
        }
    }
}