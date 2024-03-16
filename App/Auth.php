<?php

namespace App;

class Auth {

    private $connect;

    public function __construct()
    {
        $database = Connect::getInstance();
        $this->connect = $database->getConnection();
    }

    public function newUser () { // Для регистрации
        if (!$_POST['secondName']) {
            $name = trim($_POST["name"]);
            $mail = $_POST["mail"];
            $passwordHash = password_hash($_POST["password"], PASSWORD_DEFAULT);

            if (!$this->checkMail($mail)) {
                $query = "INSERT INTO users (mail, password, name, type) VALUES (?, ?, ?, ?)";
                $stmt = $this->connect->prepare($query);
                $stmt->execute([$mail, $passwordHash, $name, 'default']);
            
                return json_encode([
                    'success' => true,
                    'action' => 'registration',
                    'redirect' => '/authorization'
                ]);
            } else {
                return json_encode([
                    'success' => false,
                    'action' => 'registration',
                    'message' => 'Почта уже зарегистрирована'
                ]);
            }
        } else {
            header('Location: /');
            exit();
        }
    }

    public function getUser() { // Для авторизации
        if (!$_POST['secondName']) {
            $mail = $_POST["mail"];
            $password = $_POST["password"];

            if ($this->checkMail($mail)) {
                $query = "SELECT * FROM users WHERE mail = ?";
                $stmt = $this->connect->prepare($query);
                $stmt->execute([$mail]);
                $results = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];

                if (password_verify($password, $results['password'])) {
                    $_SESSION['login'] = 'yes';
                    $_SESSION['name'] = $results['name'];
                    $_SESSION['user_id'] = $results['id'];
                    $_SESSION['permission'] = $results['type'];
                    //$_SESSION['mail'] = $mail;
                
                    return json_encode([
                        'success' => true,
                        'action' => 'authorization',
                        'redirect' => '/'
                    ]);
                } else {
                    return json_encode([
                        'success' => false,
                        'action' => 'authorization',
                        'message' => 'Неправильная почта или пароль'
                    ]);
                }
            } else {
                return json_encode([
                    'success' => false,
                    'action' => 'authorization',
                    'message' => 'Неправильная почта или пароль'
                ]);
            }
        } else {
            header('Location: /');
            exit();
        }
    }

    public function checkMail(string $mail): bool { // Проверка свободен ли адрес эл. почты
        $query = "SELECT * FROM users WHERE mail = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->execute([$mail]);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result ? true : false;
    }

    public function logout() { // Выход с аккаунта
        if ($_SESSION['login'] === 'yes') {
            session_unset();
            session_destroy();
    
            header('Location: /');
            exit();
        } else {
            header('Location: /');
            exit();
        }
    }
}