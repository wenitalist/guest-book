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
            <textarea class='comment-input-text' maxlength='150' name='comment'></textarea>
        </label>
        <button class='comment-button' type='submit'>Опубликовать</button>
    </form>
</div>
