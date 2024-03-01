<div class='new-comment'>
    <h2>Оставить комментарий</h2>
    <form id='publish-form' action='/publish' method='POST'>
        <?php 
        if ($_SESSION['login'] === 'no') {
            echo "<label for='name'>Имя:</label><input id='name' required class='comment-input-name' type='text' maxlength='40' name='name'>";
        }
        ?>
        <label>
            Комментарий:
            <textarea class='comment-input-text' required maxlength='255' name='comment'></textarea>
        </label>
        <label style='display:none'> <!-- Защита от ботов -->
            Фамилия:
            <input type='text' name='secondName' tabindex='-1'>
        </label>
        <button class='comment-button' type='submit'>Опубликовать</button>
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

        $database = new App\Database;
        $results = $database->getComments();
        $delCheckBox = "";

        foreach ($results as $row) {
            if ($row['name_in_users'] == NULL) {
                $name = $row['name_in_comments'];
            } else {
                $name = $row['name_in_users'];
            }
            $name = $row['name_in_users'] ?: $row['name_in_comments'];

            if ($_SESSION['permission'] === 'admin') {
                $delCheckBox = "<label class='check-boxes-text'><input type='checkbox' name='checkBoxes[]' class='check-boxes' value='{$row['id']}'>Удалить</label>";
            }
        
            echo "<div class='comment-block'>
                <div class='column-comment'>
                    <p class='content'>{$row['content']}</p>
                    <p class='name'>Имя: {$name}</p>
                </div>
                <div class='row-comment'>
                    {$delCheckBox}
                    <p class='date'>Дата: {$row['date_time']}</p>
                </div>
            </div>";
        }
        if ($_SESSION['permission'] === 'admin') { echo "</form>"; }
        ?>
</div>
