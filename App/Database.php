<?php

namespace App;

class Database {

    private $connect;

    public function __construct()
    {
        $database = Connect::getInstance();
        $this->connect = $database->getConnection();
    }

    public function newUser () { // Для регистрации
        $name = $_POST["name"];
        $mail = $_POST["mail"];
        $passwordHash = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $query = "INSERT INTO users (mail, password, name, type) VALUES (?, ?, ?, ?)";
        $stmt = $this->connect->prepare($query);
        $stmt->execute([$mail, $passwordHash, $name, 'default']);

        header('Location: /');
        exit();
    }

    public function newComment() { // Для сохранения нового комментария

        header('Location: /');
        exit();
    }

    public function getUser() { // Для авторизации
        $mail = $_POST["mail"];
        $password = $_POST["password"];

        $query = "SELECT * FROM users WHERE mail = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->execute([$mail]);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        if (password_verify($password, $results[0]['password'])) {
            $_SESSION['login'] = 'yes';
            $_SESSION['name'] = $results[0]['name'];
            $_SESSION['mail'] = $mail;

            header('Location: /');
            exit();
        } else {
            // Пароль неверный
        }
    }

    public function getComments() { // Получить все комментарии

        header('Location: /');
        exit();
    }
}