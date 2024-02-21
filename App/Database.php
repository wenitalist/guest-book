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
        
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
        } else {
            $name = $_SESSION['name'];
        }

        $content = $_POST['comment'];

        $query = "INSERT INTO comments (content, date_time, user_id, name) VALUES (?, ?, ?, ?)";
        $stmt = $this->connect->prepare($query);
        $stmt->execute([$content, date('Y-m-d H:i:s'), $_SESSION['user_id'] ?? null, $name]);

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
            $_SESSION['user_id'] = $results[0]['id'];
            //$_SESSION['mail'] = $mail;

            header('Location: /');
            exit();
        } else {
            // Пароль неверный
        }
    }

    public function logout() { // Выход с аккаунта
        session_unset();
        session_destroy();

        header('Location: /');
        exit();
    }

    public function getComments() { // Получить все комментарии
        $query = "SELECT comments.content, comments.date_time, comments.name as name_in_comments, users.name as name_in_users 
                  FROM comments LEFT JOIN users ON comments.user_id = users.id ORDER BY date_time DESC";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}