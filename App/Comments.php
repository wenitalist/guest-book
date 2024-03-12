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
        try {
            if (!$_POST['secondName']) {
                if ($_FILES['images']['name'][0]) {
                    
                    $images = $this->getImages($_FILES['images']);

                    if (count($images) > 5 || $this->checkSizeImages($images)) {
                        return json_encode([
                            'success' => false,
                            'action' => 'publish',
                            'message' => 'Ошибка при загрузке картинок'
                        ]);
                    }
                }

                $name = isset($_POST['name']) ? $_POST['name'] : null;
                $content = htmlspecialchars($_POST['comment']);
    
                $query = "INSERT INTO comments (content, date_time, user_id, name) VALUES (?, ?, ?, ?)";
                $stmt = $this->connect->prepare($query);
                $stmt->execute([$content, date('Y-m-d H:i:s'), $_SESSION['user_id'] ?? null, $name]);
    
                if ($_FILES['images']['name'][0]) {
                    $index = $this->connect->lastInsertId();
                    $this->saveImages($index, $images);
                }

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
        } catch (\Exception $e) {
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

    public function getImages($imagesFiles) {
        $result = [];

        for ($i = 0; $i < count($imagesFiles['name']); $i++) {
            $result[] = [
                'name' => $imagesFiles['name'][$i],
                'type' => $imagesFiles['type'][$i],
                'tmp_name' => $imagesFiles['tmp_name'][$i],
                'error' => $imagesFiles['error'][$i],
                'size' => $imagesFiles['size'][$i]
            ];
        }

        return $result;
    }

    public function saveImages($commentIndex, array $images) {
        foreach ($images as $image) {
            move_uploaded_file($image['tmp_name'],  __DIR__ . "/../images/{$image['name']}");

            $saveOriginal = "INSERT INTO images (name, comment_id) VALUES (?, ?)";
            $stmt = $this->connect->prepare($saveOriginal);
            $stmt->execute([$image['name'], $commentIndex]);

            $imageIndex = $this->connect->lastInsertId();
            $miniature = $this->createMiniature($image);

            $saveMiniature = "INSERT INTO miniatures (image_id, miniature_blob) VALUES (?, ?)";
            $stmt = $this->connect->prepare($saveMiniature);
            $stmt->execute([$imageIndex, $miniature]);
        }
    }

    public function createMiniature(array $original) {
        $path = __DIR__ . "/../images/";

        list($origWidth, $origHeight) = getimagesize("{$path}{$original['name']}");
        list($newWidth, $newHeight) = [300, 300];

        $miniature = imagecreatetruecolor($newWidth, $newHeight);
        $originalImage = imagecreatefromjpeg("{$path}{$original['name']}");

        imagecopyresampled($miniature, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        ob_start();
        imagejpeg($miniature, null, 75);
        $blob = ob_get_clean();

        imagedestroy($miniature);
        imagedestroy($originalImage);

        return $blob;
    }

    public function checkSizeImages(array $images) {
        foreach ($images as $image) {
            if ($image['size'] >= 1048576) {
                return true;
            }
        }

        return false;
    }
}