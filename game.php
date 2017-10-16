<?php require_once 'database.php';
require_once 'session.php';
/**************************************
 * Логика игры
 **************************************/
class Game
{
    static public $results;
    static public $replace_result;
    static public $tips;

    static public function say() //Метод ответа игрока
    {
        if($_SERVER['REQUEST_METHOD'] === "POST" && $_POST['getCity'])
        {
            $city = $_POST['city'];
            if (!preg_match("/^[А-Яа-я-]+/u",$city,$matches)) //Проверка. При ошибке не сбрасывает игру
            {
                self::$results = 1;
            }
            elseif (!isset($_SESSION['game']['cities'])) //Первый поиск и запись города в сессию с городами
            {
                $obj = new DB();
                $q = "SELECT id, city_name FROM cities WHERE city_name='" . $city . "'";
                $obj->query($q);
                $res = $obj->results();
                if ($res == null)
                {
                    self::$results = 2;
                }
                else
                {
                    $obj1 = new Session();
                    $obj1->setSession($res[0]['id'], $res[0]['city_name']);
                    self::getCutWordPlayer($res[0]['city_name']);
                    self::answer();
                }
            }
            else //Следующие ответы игрока требуют двойной проверки
            {
                if (!self::getCheckLastWord($city,$_SESSION['last_letter_computer']) == true) //Проверка на соответствие последней буквы (описание ниже)
                {
                    self::$results = 3;
                }
                elseif (in_array($city,$_SESSION['game']['cities'])) //Проверка на наличие дубликата
                {
                    self::$results = 4;
                }
                else
                {
                    $obj = new DB();
                    $q = "SELECT id, city_name FROM cities WHERE city_name='".$city."'";
                    $obj->query($q);
                    $res = $obj->results();
                    if ($res == null) {
                        self::$results = 2;
                    }
                    else
                    {
                        $obj1 = new Session();
                        $obj1->setSession($res[0]['id'], $res[0]['city_name']);
                        self::getCutWordPlayer($res[0]['city_name']);
                        self::answer();
                    }
                }
            }
        }
    }

    static public function answer() //Метод ответа компьютера
    {
        $query_id = array_keys($_SESSION['game']['cities']);
        $string_id = implode(",", $query_id);
        self::difficulty($string_id); //Метод сложности игры
        $obj = new DB();
        $q = "SELECT id, city_name FROM cities WHERE city_name LIKE '".$_SESSION['last_letter_player']."%' AND id NOT IN (".self::$replace_result.")";
        $obj->query($q);
        $res_all = $obj->results();
        $count = count($res_all) -1; // Реализована человечность выбора компьютера
        $rand_city = mt_rand(0,$count); // Выбирает всегда случайный вариант
        if (in_array($res_all[$rand_city]['city_name'],$_SESSION['game']['cities'])) //Проверка дубликатов
        {
            self::$results = 5;
        }
        else
        {
            $obj1 = new Session();
            $obj1->setSession($res_all[$rand_city]['id'],$res_all[$rand_city]['city_name']);
            self::getCutWordComputer($res_all[$rand_city]['city_name']);
        }
    }

    static public function difficulty($subject) //Метод реализации сложности игры.
        /*
         * Реализована поиском случайных чисел в строке с ключами и заменой использованых id_cities на случаные числа.
         * Вставляем палки в колеса компьютеру
         */
    {
        if (isset($_SESSION['selected_difficulty_easy'])) //200 случайных чисел от 0 до 410
        {
            $search = array ();
            for ($i = 0; $i <= 200; $i++) {
                $search[$i] = rand(0, 410);
            }
            $replace = mt_rand(1,3); // Заменяем на от 1 до 3. Смотрите Закон Бенфорда
            self::$replace_result = str_replace($search, $replace, $subject);
            return self::$replace_result;
        }
        elseif (isset($_SESSION['selected_difficulty_normal']))
        {
            $search = array ();
            for ($i = 0; $i <= 100; $i++) {
                $search[$i] = rand(0, 410);
            }
            $replace = mt_rand(1,6); // Заменяем на от 1 до 6. Смотрите Закон Бенфорда
            self::$replace_result = str_replace($search, $replace, $subject);
            return self::$replace_result;
        }
        elseif (isset($_SESSION['selected_difficulty_hard']))
        {
            $search = array ();
            for ($i = 0; $i <= 50; $i++) {
                $search[$i] = rand(0, 410);
            }
            $replace = mt_rand(1,9); // Заменяем на от 1 до 9. Смотрите Закон Бенфорда
            self::$replace_result = str_replace($search, $replace, $subject);
            return self::$replace_result;
        }
        else
        {
            $search = array ();
            for ($i = 0; $i <= 10; $i++) {
                $search[$i] = rand(0, 410);
            }
            $replace = mt_rand(1,9);
            self::$replace_result = str_replace($search, $replace, $subject);
            return self::$replace_result;
        }
    }

    static public function getTips() //Метод выдачи подсказок. К-во зависит от сложности
    {
        if(isset($_POST['getTips']))
        {
            if (isset($_SESSION['game']['cities']))
            {
                --$_SESSION['tips_click'];
                $query_id = array_keys($_SESSION['game']['cities']);
                $string_id = implode(",", $query_id);
                $pc_city = $_SESSION['game']['cities'];
                $last_letter_pc = mb_substr(end($pc_city), -1);
                $obj = new DB();
                $q = "SELECT id, city_name FROM cities WHERE city_name LIKE '".$last_letter_pc."%' AND id NOT IN (".$string_id.")";//
                $obj->query($q);
                $res_all = $obj->results();
                $count = count($res_all) -1;
                $rand_city_tips = mt_rand(0,$count);
                self::$tips = $res_all[$rand_city_tips]['city_name'];
                return self::$tips;
            }
        }
    }

    static public function getCutWordPlayer($word) //Метод проверки и обрезки слова игрока
    {
        $last = mb_substr($word, -1);
        switch ($last)
        {
            case 'ы':
            case 'ь':
            case 'ъ':
            case 'й':
                $last = mb_substr($word, -2, 1);
                $_SESSION['last_letter_player'] = $last;
                break;
            default:
                $_SESSION['last_letter_player'] = $last;
        }
    }

    static public function getCutWordComputer($word) //Метод проверки и обрезки слова компьютера
    {
        $last = mb_substr($word, -1);
        switch ($last)
        {
            case 'ы':
            case 'ь':
            case 'ъ':
            case 'й':
                $last = mb_substr($word, -2, 1);
                $_SESSION['last_letter_computer'] = $last;
                break;
            default:
                $_SESSION['last_letter_computer'] = $last;
        }
    }

    static public function getCheckLastWord($player_city,$pc_city) //Метод проверки соответсвия последней буквы компьютера и игрока.
    {
        $first_letter_player = mb_strtolower(mb_substr($player_city,0,+1));
        if (strcasecmp($pc_city, $first_letter_player) == 0)
        {
            return true;
        }
    }

    static public function ResultsSwitch() //Метод вывода ошибок
    {
        switch (self::$results)
        {
            case 1:
                echo "<div class=\"alert alert-danger\"><strong>Ошибка! </strong>Введите название города на кирилице</div>";
                break;
            case 2:
                echo "<div class=\"alert alert-danger\"><strong>Ошибка! </strong>Такого города не существует</div>";
                break;
            case 3:
                echo "<div class=\"alert alert-danger\"><strong>Вы проиграли! </strong>Последняя буква не соответствует</div>";
                $_SESSION['disable_game'] = 'disabled';
                break;
            case 4:
                echo "<div class=\"alert alert-danger\"><strong>Вы проиграли! </strong>Такой город уже называли</div>";
                $_SESSION['disable_game'] = 'disabled';
                break;
            case 5:
                echo "<div class=\"alert alert-success\"><strong>Поздравляю! </strong>Вы победили</div>";
                $_SESSION['disable_game'] = 'disabled';
                break;
        }
    }
}