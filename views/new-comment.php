<form action="/add-comment" class="form">
    <?php 
        if ($_SESSION['login'] === NULL) {
            echo "<label>Имя:<input type='text' maxlength='50'></label>";
        }
    ?>
    <label>
        Комментарий:
        <input type="text" maxlength="150">
    </label>
    <button type='submit'>Отправить</button>
</form>