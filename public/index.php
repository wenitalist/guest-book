<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

require_once(__DIR__ . '/../vendor/autoload.php');

session_start();

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = 'no';
}

$classUrl = new \App\Url;
$response = $classUrl->checkUrl($_SERVER['REQUEST_URI']);
?>

<DOCTYPE html>
<html lang="ru">
    <header>
        <meta charset="UTF-8">
        <title>Главная страница</title>
        <link href="style.css" rel="stylesheet">
        <script src="../js/script.js"></script>
    </header>
    <main>
        <div class='main-block'>
            <?php 
            if (str_contains($response, '.php')) {
                require_once("../views/menu.php");
                require_once($response);
            }
            ?>
        </div>
    </main>
</html>
