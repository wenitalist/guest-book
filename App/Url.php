<?php

namespace App;

class Url {
    public const MASS_URL = [
        '/',
        '/authorization',
        '/registration',
        '/auth',
        '/regis',
        '/publish',
        '/delete',
        '/logout'
    ];

    public function checkUrl (string $request): string {
        $url = explode('?', $request);
        $url = $url[0];

        switch ($url) {
            case self::MASS_URL[0]:
                return "../views/main.php";
            case self::MASS_URL[1]:
                return "../views/authorization.php";
            case self::MASS_URL[2]:
                return "../views/registration.php";
            case self::MASS_URL[3]:
                $auth = new Auth();
                echo $auth->getUser();
                exit();
            case self::MASS_URL[4]:
                $auth = new Auth();
                echo $auth->newUser();
                exit();
            case self::MASS_URL[5]:
                $comments = new Comments();
                echo $comments->newComment();
                exit();
            case self::MASS_URL[6]:
                $comments = new Comments();
                echo $comments->deleteComments();
                exit();
            case self::MASS_URL[7]:
                $auth = new Auth();
                $auth->logout();
                exit();
            default:
                return "../views/error404.php";
        }
    }

    public function setTitle(string $url) {
        $url = explode('?', $url);
        $url = $url[0];

        switch ($url) {
            case self::MASS_URL[0]:
                return '<title>Главная страница</title>';
            case self::MASS_URL[1]:
                return '<title>Авторизация</title>';
            case self::MASS_URL[2]:
                return '<title>Регистрация</title>';
            default:
                return '<title>Страница не найдена</title>';
        }
    }
}