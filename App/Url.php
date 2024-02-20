<?php

namespace App;

class Url {
    public const MASS_URL = [
        '/',
        '/authorization',
        '/registration',
        '/auth',
        '/regis',
        '/publish'
    ];

    public function checkUrl (string $request): ?string {
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
            $database->getUser();

            return NULL;
        }
        elseif ($url === self::MASS_URL[4]) { // Регистрация
            $database = new Database();
            $database->newUser();

            return NULL;
        }
        elseif ($url === self::MASS_URL[5]) { // Новый комментарий
            $database = new Database();
            $database->newComment();

            return NULL;
        }
        else { // Страница не найдена
            return "../views/error404.php";
        }
    }
}