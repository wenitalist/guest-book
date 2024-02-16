<?php

require_once(__DIR__ . '/../vendor/autoload.php');

?>

<DOCTYPE html>
<html lang="ru">
    <header>
        <meta charset="UTF-8">
        <title>Главная страница</title>
        <link href="style.css" rel="stylesheet">
    </header>
    <main>
        <div class="main-block">
            <nav>
                <ul class="menu">
                    <a href="/"><img src="logo.png" alt="Логотип"></a>
                    <li><a href="/authorization">Вход</a></li>
                    <li><a href="/registration">Регистрация</a></li>
                </ul>
            </nav>
            <form action="/zxc" class="form">
                <label>
                    Имя:
                    <input type="text" name="">
                </label>
                <label>
                    Комментарий:
                    <input type="text">
                </label>
                <button>Отправить</button>
            </form>
        </div>
    </main>
</html>
