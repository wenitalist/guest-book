<?php

namespace App;

class Comments {

    private $connect;

    public function __construct() {
        $database = Connect::getInstance();
        $this->connect = $database->getConnection();
    }

    public function getComments(): array { // Получить все комментарии
        $query = "SELECT comments.id, comments.content, comments.date_time, comments.name as name_in_comments, users.name as name_in_users FROM comments 
                LEFT JOIN users ON comments.user_id = users.id 
                ORDER BY date_time DESC";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function newComment(): string { // Для сохранения нового комментария
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
                    $index = (int)$this->connect->lastInsertId();
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

    public function deleteComments(): string { // Удаление комментариев 
        if ($_SESSION['permission'] === 'admin') {
            if ($_POST['checkBoxes']) {
            
                $imagesNames = $this->getImagesNames();

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

                $this->deleteImages($imagesNames);
    
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

    public function deleteImages(array $imagesNames): void {
        if ($imagesNames) {
            $path = __DIR__ . "/../images/";

            foreach ($imagesNames as $image) {
                if (file_exists("{$path}{$image['name']}")) {
                    unlink("{$path}{$image['name']}");
                }
            }
        }
    }

    public function getImagesNames(): array {
        $query = "SELECT images.name FROM comments RIGHT JOIN images ON comments.id = images.comment_id WHERE comments.id IN (";
        for($i = 0; $i < count($_POST['checkBoxes']); $i++) {
            $query = $query . '?';
            if (($i + 1) !== count($_POST['checkBoxes'])) {
                $query = $query . ', ';
            }
        }
        $query = $query . ");";

        $stmt = $this->connect->prepare($query);
        $stmt->execute($_POST['checkBoxes']);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getImages(array $imagesFiles): array {
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

    public function saveImages(int $commentIndex, array $images): void {
        $path = __DIR__ . "/../images/";

        foreach ($images as $image) {

            if(file_exists("{$path}{$image['name']}")) {
                $image['name'] = $this->renameFile($path, $image['name']);
            }

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

    public function renameFile(string $path, string $name): string {
        $newName = $name;

        if (strlen(str_replace('.jpg', '', $name)) < 5) {
            while (file_exists("{$path}{$newName}")) {
                $newName = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
            }
        } else {
            while (file_exists("{$path}{$newName}")) {
                $newName = str_shuffle(str_replace('.jpg', '', $newName));
            }
        }

        return $newName . '.jpg';
    }

    public function createMiniature(array $original): string {
        $path = __DIR__ . "/../images/";

        list($origWidth, $origHeight) = getimagesize("{$path}{$original['name']}");
        list($newWidth, $newHeight) = $this->getNewSizes($origWidth, $origHeight);

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

    public function getNewSizes(int $origWidth, int $origHeight): array {
        $width = 300; 
        $height = 300;

        if ($origWidth >= $origHeight) {
            $height = ($origHeight / $origWidth) * $width;
        } else {
            $width = ($origWidth / $origHeight) * $height;
        }

        return [$width, $height];
    }

    public function checkSizeImages(array $images): bool {
        foreach ($images as $image) {
            if ($image['size'] >= 1048576) {
                return true;
            }
        }

        return false;
    }
}