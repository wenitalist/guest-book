<div class="authorization">
    <?php 
        if ($_SESSION['login'] === NULL) {
            echo "<h2>Авторизация</h2>
            <form action='/auth' class='form' method='POST'>
                <label>
                    Почта:
                    <input required class='authentication' type='text' maxlength='40' name='mail'>
                </label>
                <label>
                    Пароль:
                    <input required class='authentication' type='text' maxlength='20' name='password'>
                </label>
                <button class='auth-button' type='submit'>Авторизироваться</button>
            </form>";
        } else {
            header("Location: /");
            exit;
        }
    ?>
</div>