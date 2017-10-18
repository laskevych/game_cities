<?php
session_start();
require_once 'game.php';
//require_once 'filemanager.php'; //Раскомментируйте для загрузки городов в первый раз.
Game::say();
Game::getTips();
Session::difficulty();
Session::setGameOver();
Session::delSession();
Session::checkTips();
/******************************************************************************************************************
 * Не закончил функционал загрузки файла. Для загрузки файла с городами
 * раскомментируйте эти два метода. Перегрузите страницу 1 раз.
 * Таблица CREATE TABLE cities(id INT NOT NULL AUTO_INCREMENT, city_name VARCHAR(255) NOT NULL, PRIMARY KEY (id))
 * Для полной работоспособности нужны: Apache PHP7.0, PHP 7.0, MySQL 5.7, DB: homework
 * Не используйте город "Авдеевка". Не работает :D Причину не знаю
 *****************************************************************************************************************/
//$file = new FileManager();
//$file->getOpenFile(); //Для загрузки файла с городами
//$file->getUploadFile(); //Раскомметируйте эти два метода. Перегрузите страницу 1 раз. Закомментрируйте обратно.
?>
<!doctype html>
<html lang="ru-RU">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <title>Игра "Города"</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Игра "Города"</h2>
        </div>
        <div class="col-6">
            <form class="form-inline col-12" action="" method="post">
                <fieldset <?php echo $_SESSION['disable_game']?>>
                    <div class="form-group col-12" style="padding-bottom: 10px">
                        <input type="text" name="city" id="searchCity" class="form-control" autocomplete="<?php echo $_SESSION['autocomplete']?>" placeholder="Введите город">
                    </div>
                </fieldset>
                <fieldset <?php echo $_SESSION['disable_difficulty']?>>
                    <div class="form-group col-12" style="padding-bottom: 10px">
                        <select class="custom-select mb-2 mr-sm-2 mb-sm-0 col-12" name="difficulty">
                            <option selected>Сложность</option>
                            <option <?php echo $_SESSION['selected_difficulty_easy']?> value="1">Легко</option>
                            <option <?php echo $_SESSION['selected_difficulty_normal']?> value="2">Нормально</option>
                            <option <?php echo $_SESSION['selected_difficulty_hard']?> value="3">Хардкор</option>
                        </select>
                </fieldset>
                <fieldset <?php echo $_SESSION['disable_game']?> class="col-12">
                    <div class="form-group" style="padding-bottom: 5px">
                        <input type="submit" name="getCity" class="btn btn-success col-12" value="Отправить">
                    </div>
                </fieldset>
            </form>
            <form class="form-inline col-12" action="" method="post">
                <fieldset <?php echo $_SESSION['disable_game']; echo $_SESSION['disable_tips']?> class="col-12">
                    <div class="form-group" style="padding-bottom: 5px">
                        <button type="submit" name="getTips" class="btn btn-info col-12">Подсказка <span class="badge badge-pill badge-danger"><?php echo $_SESSION['tips_click'];?></span></button>
                    </div>
                </fieldset>
            </form>
            <form class="form-inline col-12" action="" method="post">
                <div class="col-sm-12" style="padding-bottom: 5px">
                    <input type="submit" name="Exit" class="btn btn-danger col-12" value="Обнулить">
                </div>
            </form>
            <div class="col-12">
                <h5>Подсказка</h5>
                <ul class="list-group">
                    <li class="list-group-item"><?php echo Game::$tips;?></li>
                </ul>
            </div>
            <div class="col-12">
                <?php Game::ResultsSwitch();?>
            </div>
        </div>
        <div class="col-6">
            <h3>Результаты</h3>
            <div class="col-12" style="height: 500px; overflow-y: auto">
                <span>Последння буква: </span><span class="badge badge-warning"><?php echo $_SESSION['last_letter_computer']?></span>
                <?php Session::viewSession()?>
            </div>
        </div>
        <div class="col-12">
            <h3>Правила игры</h3>
            <p>В "Города" играют двое и более человек, в которой каждый участник в свою очередь называет реально существующий город любой страны, название которого начинается на ту букву, которой оканчивается название предыдущего участника.</p>
            <p>Исключением в правилах игры являются названия, оканчивающиеся на «Ь» (мягкий знак) и «Ъ» (твёрдый знак): в таких случаях участник называет город на предпоследнюю букву. Существует ряд городов, названия которых начинаются на букву «Ы» (Ыштык, Ыгдыр, Ыспарта, Ышыклы и др.), так что пропускать эту букву считается против правил. При этом ранее названные города нельзя употреблять снова. Первый участник выбирает любой город. Во время игры запрещается пользоваться справочным материалом.</p>
            <p>Игра оканчивается, когда очередной участник не может назвать нового города, однако из-за продолжительности и монотонности игрового процесса игра зачастую оканчивается ничьей.</p>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>
</html>


