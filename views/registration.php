<div class="registration">
    <?php 
        if ($_SESSION['login'] === 'no') {
            echo "<h2>Регистрация</h2>
            <form action='/regis' class='form' method='POST'>
                <label>
                    Имя:
                    <input required class='authentication' type='text' maxlength='50' name='name'>
                </label>
                <label>
                    Почта:
                    <input required class='authentication' type='text' maxlength='40' name='mail'>
                </label>
                <label>
                    Пароль:
                    <input required class='authentication' type='password' maxlength='20' name='password'>
                </label>
                <button class='auth-button' type='submit'>Зарегистрироваться</button>
            </form>";
        } else {
            header("Location: /");
            exit;
        }
    ?>
</div>