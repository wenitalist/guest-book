<div class='new-comment'>
    <h2>Оставить комментарий</h2>
    <form action='/publish' class='form' method='POST'>
        <?php 
        if ($_SESSION['login'] === NULL) {
            echo "<label>Имя:<input required class='comment-input' type='text' maxlength='40'></label>";
        }
        ?>
        <label>
            Комментарий:
            <textarea class='comment-input-text' maxlength='150'></textarea>
        </label>
        <button class='comment-button' type='submit'>Опубликовать</button>
    </form>
</div>
