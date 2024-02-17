<?php

require_once(__DIR__ . '/../vendor/autoload.php');

session_start();

const MASS_URL = [
    "/",
    "/authorization",
    "/registration"
];

?>

<DOCTYPE html>
<html lang="ru">
    <header>
        <meta charset="UTF-8">
        <title>Главная страница</title>
        <link href="style.css" rel="stylesheet">
    </header>
    <main>
        <div class='main-block'>
            <?php 
                $url = $_SERVER['REQUEST_URI'];
                $url = explode('?', $url);
                $url = $url[0];

                if ($url === MASS_URL[0]) { // Главная
                    require_once("../views/menu.php");
                    require_once("../views/new-comment.php");
                }
                elseif ($url === MASS_URL[1]) { // Авторизация
                    require_once("../views/menu.php");
                }
                elseif ($url === MASS_URL[2]) { // Регистрация
                    require_once("../views/menu.php");
                }
                else { // Страница не найдена
                    require_once("../views/menu.php");
                    require_once("../views/error404.php");
                }
            ?>
        </div>
    </main>
</html>
