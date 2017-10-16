<?php
/********************************************************************
 * Временная регистрация игрока. Не реализована. Не хватило времени
 ********************************************************************/
/*if ($_SESSION['players']['player'])
{
    header('Location: http://game/index.php');
}*/
session_start();
require_once 'game.php';
require_once 'filemanager.php';
Session::addPlayer();

?>
<!doctype html>
<html lang="ru-RU">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Игра "Города"</h2>
        </div>
        <div class="col-12">
            <form class="form-inline" action="" method="post">
                <input type="text" name="player_name" class="form-inline col-sm-12" autocomplete="off" placeholder="Выберите имя игрока">
                <small class="form-text text-muted">Используйте кирилицу</small>
                <input type="submit" name="getAddPlayer" class="btn btn-success btn-sm col-sm-12" value="Начать игру">
        </div>
        <div class="col-12">
            <h3>Лучшие игроки</h3>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>
</html>