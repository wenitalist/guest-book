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
        if (!$_POST['secondName']) {
            $name = $_POST["name"];
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

    public function checkMail(string $mail): bool { // Проверка свободен ли адрес эл. почты
        $query = "SELECT * FROM users WHERE mail = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->execute([$mail]);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result ? true : false;
    }

    public function newComment() { // Для сохранения нового комментария
        if (!$_POST['secondName']) {
            $name = isset($_POST['name']) ? $_POST['name'] : null;
            $content = $_POST['comment'];

            $query = "INSERT INTO comments (content, date_time, user_id, name) VALUES (?, ?, ?, ?)";
            $stmt = $this->connect->prepare($query);
            $stmt->execute([$content, date('Y-m-d H:i:s'), $_SESSION['user_id'] ?? null, $name]);

            header('Location: /');
            exit();
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

    public function logout() { // Выход с аккаунта
        session_unset();
        session_destroy();

        header('Location: /');
        exit();
    }

    public function getComments() { // Получить все комментарии
        $query = "SELECT comments.id, comments.content, comments.date_time, comments.name as name_in_comments, users.name as name_in_users 
                  FROM comments LEFT JOIN users ON comments.user_id = users.id ORDER BY date_time DESC";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteComments() { // Удаление комментариев 
        if ($_POST['checkBoxes']) {
            $query = "DELETE FROM comments WHERE id IN (";

            for($i = 0; $i < count($_POST['checkBoxes']); $i++) {
                $query = $query . '?';
                if (($i + 1) !== count($_POST['checkBoxes'])) {
                    $query = $query . ', ';
                }
            }
            $query = $query . ");";
            $stmt = $this->connect->prepare($query);
            $stmt->execute($_POST['checkBoxes']);

            return json_encode([
                'success' => true,
                'redirect' => '/'
            ]);
        } else {
            return json_encode([
                'success' => false,
                'message' => 'Выбрано 0 комментариев'
            ]);
        }
    }
}