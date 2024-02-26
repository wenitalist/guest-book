<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

require_once(__DIR__ . '/../vendor/autoload.php');

session_start();

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = 'no';
}

?>

<DOCTYPE html>
<html lang="ru">
    <header>
        <meta charset="UTF-8">
        <title>Главная страница</title>
        <link href="style.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../js/script.js"></script>
    </header>
    <main>
        <div class='main-block'>
            <?php 
                require_once("../views/menu.php");

                $classUrl = new \App\Url;
                $page = $classUrl->checkUrl($_SERVER['REQUEST_URI']);
                require_once($page);
            ?>
        </div>
    </main>
</html>
