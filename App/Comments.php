<?php

namespace App;

class Comments {

    private $connect;

    public function __construct() {
        $database = Connect::getInstance();
        $this->connect = $database->getConnection();
    }

    public function getComments() { // Получить все комментарии
        $query = "SELECT comments.id, comments.content, comments.date_time, comments.name as name_in_comments, users.name as name_in_users 
                  FROM comments LEFT JOIN users ON comments.user_id = users.id ORDER BY date_time DESC";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function newComment() { // Для сохранения нового комментария
        if (!$_POST['secondName']) {
            $name = isset($_POST['name']) ? $_POST['name'] : null;
            $content = htmlspecialchars($_POST['comment']);

            $query = "INSERT INTO comments (content, date_time, user_id, name) VALUES (?, ?, ?, ?)";
            $stmt = $this->connect->prepare($query);
            $stmt->execute([$content, date('Y-m-d H:i:s'), $_SESSION['user_id'] ?? null, $name]);

            return json_encode([
                'success' => true,
                'action' => 'publish',
                'redirect' => '/'
            ]);
        } else {
            return json_encode([
                'success' => false,
                'action' => 'publish',
                'message' => 'Ошибка при публикации'
            ]);
        }
    }

    public function deleteComments() { // Удаление комментариев 
        if ($_SESSION['permission'] === 'admin') {
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
        } else {
            return json_encode([
                'success' => false,
                'message' => 'Доступ запрещен'
            ]);
        }
    }
}