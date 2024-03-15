<div class='new-comment'>
    <h2>Оставить комментарий</h2>
    <form id='publish-form' action='/publish' method='POST' enctype="multipart/form-data">
        <?php 
        if ($_SESSION['login'] === 'no') {
            echo "<label for='inputName'>Имя:</label><input required id='inputName' class='comment-input-name' type='text' maxlength='40' name='name'>";
        }
        ?>
        <label>
            Комментарий:
            <textarea required id='inputComment' class='comment-input-text' rows='5' maxlength='1500' name='comment'></textarea>
        </label>
        <p class='images-message'>Можно прикрепить до 5 картинок c максимальным размером до 1 мб, в формате jpeg</p>
        <input type="file" id='input-images' name="images[]" multiple accept="image/jpeg">
        <label style='display:none'> <!-- Защита от ботов -->
            Фамилия:
            <input type='text' name='secondName' tabindex='-1'>
        </label>
        <div class='publish-form-row'>
            <p id='publish-form-error-message'></p>
            <button class='comment-button' type='submit'>Опубликовать</button>
        </div>
    </form>
</div>
<?php 
if ($_SESSION['permission'] === 'admin') {
    echo "<div class='admin-panel'>
        <h3>Админ панель</h3>
        <div class='admin-panel-del-comments-row'>
            <label>Удалить выбранные комментарии: </label>
            <button class='del-button' id='del-button' type='submit' form='del-form'>Удалить</button>
            <p id='del-message'></p>
        </div>
    </div>";
}
?>
<div class='comments-block'>
        <?php 
        if ($_SESSION['permission'] === 'admin') { echo "<form id='del-form' action='/delete' method='POST'>"; }

        $comments = new App\Comments;
        $results = $comments->getComments();
        $delCheckBox = "";

        foreach ($results as $row) {
            $name = $row['name_in_users'] ?: $row['name_in_comments'];
            $tagsWithImages = "";

            if ($_SESSION['permission'] === 'admin') {
                $delCheckBox = "<label class='check-boxes-text'><input type='checkbox' name='checkBoxes[]' class='check-boxes' value='{$row['id']}'>Удалить</label>";
            }

            if ($row['images_names'] !== null) {
                $images = explode(',', $row['images_names']);

                foreach ($images as $image) {
                    $src = "";

                    if (file_exists(__DIR__ . "/../images/miniatures/{$image}")) {
                        $src = "miniatures/{$image}";
                    } else {
                        $src = "miniatures/error-image.jpg";
                    }
                    $tagsWithImages .= "<img id='{$row['id']}' class='miniatures' src={$src} name='{$image}' alt='miniature' onclick='openModalWindow(this.name)'>";
                }
            }
        
            echo "<div class='comment-block'>
                <div class='column-comment'>
                    <p class='content'>{$row['content']}</p>
                    <div class='miniatures-block'>
                        {$tagsWithImages}
                    </div>
                    <p class='name'>Имя: {$name}</p>
                </div>
                <div class='row-comment'>
                    {$delCheckBox}
                    <p class='date'>Дата: {$row['date_time']}</p>
                </div>
            </div>";
        }
        if ($_SESSION['permission'] === 'admin') { echo "</form>"; }

        echo "<div class='modal-window' id='modal-window' onclick='closeModalWindow()'>
            <div class='modal-content'>
                <div class='div-for-image' onclick='imageClick(event)'>
                    <img class='modal-image' id='modal-image' src='' alt='image' onclick='imageClick(event)'>
                </div>
            </div>
        </div>";
        ?>
</div>
