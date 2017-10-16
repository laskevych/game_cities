<?php
/**************************************
 * Работа с сессиями
 **************************************/
class Session
{
	static public $session_error;
    static public function setSession($city_id,$city_name) //Метод записи города в сессию
    {
        $_SESSION['game']['cities'][$city_id] = $city_name;
    }
    static public function delSession() //Метод сброса игры
    {
        if($_SERVER['REQUEST_METHOD'] === "POST" && $_POST['Exit'])
        {
            session_unset($_SESSION['game']);
        }
    }
    static public function viewSession() //Метод вывода списка городов в массиве сессии
    {
        if(isset($_SESSION['game']['cities'])) {
            echo "<ul class=\"list-group\">";
            foreach (array_reverse($_SESSION['game']['cities']) as $city_name) {
                echo "<li class=\"list-group-item\">".$city_name."</li>";
            }
        }
        echo "</ul>";
    }
    static public function difficulty() //Метод реализации сложности игры
    {
        if (!isset($_SESSION['disable_difficulty']))
        {
            if($_SERVER['REQUEST_METHOD'] === "POST" && $_POST['getCity'])
            {
                switch ($_POST['difficulty'])
                {
                    case 1:
                        $_SESSION['disable_difficulty'] = 'disabled'; //Блокировка выбора сложности
                        $_SESSION['selected_difficulty_easy'] = 'selected';
                        $_SESSION['autocomplete'] = 'on'; //Автозаполнение
                        $_SESSION['tips_click'] = 5; //К-во подсказов
                        break;
                    case 2:
                        $_SESSION['disable_difficulty'] = 'disabled'; //Блокировка выбора сложности
                        $_SESSION['selected_difficulty_normal'] = 'selected';
                        $_SESSION['autocomplete'] = 'off'; //Автозаполнение
                        $_SESSION['tips_click'] = 3; //К-во подсказов
                        break;
                    case 3:
                        $_SESSION['disable_difficulty'] = 'disabled'; //Блокировка выбора сложности
                        $_SESSION['selected_difficulty_hard'] = 'selected';
                        $_SESSION['autocomplete'] = 'off'; //Автозаполнение
                        $_SESSION['tips_click'] = 1; //К-во подсказов
                        break;
                    default:
                        $_SESSION['disable_difficulty'] = 'disabled'; //Блокировка выбора сложности
                        $_SESSION['selected_difficulty_easy'] = 'selected';
                        $_SESSION['autocomplete'] = 'on'; //Автозаполнение
                        $_SESSION['tips_click'] = 5; //К-во подсказов
                        break;
                }
            }
        }
    }
    static public function setGameOver() //Метод реализации проигрыша. Блокировка input
    {
        switch (Game::$results)
        {
            case 2:
                $_SESSION['disable_game'] = 'disabled';
                break;
            case 3:
                $_SESSION['disable_game'] = 'disabled';
                break;
            case 4:
                $_SESSION['disable_game'] = 'disabled';
                break;
            case 5:
                $_SESSION['disable_game'] = 'disabled';
                break;
        }
    }

    static public function checkTips() //Метод блокировки input подсказок после их окончания.
    {
        if(isset($_POST['getTips']))
        {
            if ($_SESSION['tips_click'] == 0)
            {
                $_SESSION['disable_tips'] = 'disabled';
            }
        }
    }


     // TODO: Таблица лучних игроков. Не реализовано.

    //$obj = new DB();
    //$q = "INSERT INTO players('player') VALUES ('."$player_name".')"
    static public function setSessionPlayerName($player_name) //тест таблицы лидеров, какие значания передаем?
    {
        $_SESSION['players']['player']['player_name'] = $player_name;
        echo "<pre>";
        print_r($_SESSION['players']['player']['player_name']);
    }
	static public function addPlayer()
	{
		if($_SERVER['REQUEST_METHOD'] === "POST" && $_POST['getAddPlayer'])
		{
			$player_name = $_POST['player_name'];
            if (!preg_match("/^[А-Яа-я-]+/u",$player_name,$matches))
            {
                self::$session_error = 1;
				echo 'error player name';
            }
			else
			{
                $_SESSION['players']['player']['player_name'] = $player_name;
                echo "<pre>";
                echo 'player add';
                print_r($_SESSION['players']['player']['player_name']);
                echo "</pre>";
			}
		}
	}
	static public function getCheckSessionPlayer()
    {
        if (!$_SESSION['players']['player'])
        {
            header('Location: http://www.facebook.com/');
        }
    }
}