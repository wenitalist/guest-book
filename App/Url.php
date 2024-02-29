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

        if ($url === self::MASS_URL[0]) { // Главная страница
            return "../views/main.php";
        }
        elseif ($url === self::MASS_URL[1]) { // Страница авторизации
            return "../views/authorization.php";
        }
        elseif ($url === self::MASS_URL[2]) { // Страница регистрации
            return "../views/registration.php";
        }
        elseif ($url === self::MASS_URL[3]) { // Авторизация
            $database = new Database();
            echo $database->getUser();
            exit();
        }
        elseif ($url === self::MASS_URL[4]) { // Регистрация
            $database = new Database();
            echo $database->newUser();
            exit();
        }
        elseif ($url === self::MASS_URL[5]) { // Новый комментарий
            $database = new Database();
            $database->newComment();
            exit();
        }
        elseif ($url === self::MASS_URL[6]) { // Удаление комментариев
            $database = new Database();
            $database->deleteComments();
            exit();
        }
        elseif ($url === self::MASS_URL[7]) { // Выход с аккаунта
            $database = new Database();
            $database->logout();
            exit();
        }
        else { // Страница не найдена
            return "../views/error404.php";
        }
    }

    public function setTitle(string $request) {
        switch ($request) {
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