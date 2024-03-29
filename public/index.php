<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

require_once(__DIR__ . '/../vendor/autoload.php');

$JS_VERSION = 1.2;
$CSS_VERSION = 1.6;

session_start();

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = 'no';
    $_SESSION['permission'] = 'default';
}

$classUrl = new \App\Url;
$response = $classUrl->checkUrl($_SERVER['REQUEST_URI']);
?>

<DOCTYPE html>
<html lang="ru">
    <header>
        <meta charset="UTF-8">
        <?php 
            echo "<link href='style.css?v={$CSS_VERSION}' rel='stylesheet'>
                <script src='script.js?v={$JS_VERSION}'></script>";
        ?>
        <?php echo $classUrl->setTitle($_SERVER['REQUEST_URI']) ?>
    </header>
    <main>
        <div class='main-block'>
            <?php 
                require_once("../views/menu.php");
                require_once($response);
            ?>
        </div>
    </main>
</html>
