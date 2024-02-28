<div class='new-comment'>
    <h2>Оставить комментарий</h2>
    <form action='/publish' class='form' method='POST'>
        <?php 
        if ($_SESSION['login'] === 'no') {
            echo "<label>Имя:<input required class='comment-input' type='text' maxlength='40' name='name'></label>";
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
<div class='comments-block'>
    <?php 
    $database = new App\Database;
    $results = $database->getComments();

    foreach ($results as $row) {
        if ($row['name_in_users'] == NULL) {
            $name = $row['name_in_comments'];
        } else {
            $name = $row['name_in_users'];
        }

        echo "<div class='comment-block'>
            <p class='content'>{$row['content']}</p>
            <p class='name'>Имя: {$name}</p>
            <p class='date'>Дата: {$row['date_time']}</p>
        </div>";
    }
    ?>
</div>
