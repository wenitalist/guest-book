<div class="authorization">
    <?php 
        if ($_SESSION['login'] === NULL) {
            echo "<h2>Авторизация</h2>
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