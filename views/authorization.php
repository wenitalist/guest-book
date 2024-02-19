<div class="authorization">
    <?php 
        if ($_SESSION['login'] === NULL) {
            echo "<p>Авторизация</p>
            <form action='/auth' class='form'>
                <label>
                    Почта:
                    <input required class='authentication' type='text' maxlength='40'>
                </label>
                <label>
                    Пароль:
                    <input required class='authentication' type='text' maxlength='20'>
                </label>
                <button class='auth-button' type='submit'>Авторизироваться</button>
            </form>";
        } else {
            header("Location: /");
            exit;
        }
    ?>
</div>