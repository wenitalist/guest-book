<div class='new-comment'>
    <?php 
        if ($_SESSION['login'] === NULL) {
            echo "<p>Оставить комментарий</p>
            <form action='/publish' class='form'>
                <label>
                    Имя:
                    <input required class='comment-input' type='text' maxlength='40'>
                </label>
                <label>
                    Комментарий:
                    <textarea class='comment-input-text' maxlength='150'></textarea>
                </label>
                <button class='comment-button' type='submit'>Опубликовать</button>
            </form>";
        } else {
            echo "<p>Оставить комментарий</p>
            <form action='/publish' class='form'>
                <label>
                    Комментарий:
                    <textarea class='comment-input-text' maxlength='150'></textarea>
                </label>
                <button class='comment-button' type='submit'>Опубликовать</button>
            </form>";
        }
    ?>
</div>