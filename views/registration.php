<div class="registration">
    <?php 
        if ($_SESSION['login'] === NULL) {
            echo "<p>Регистрация</p>
            <form action='/regis' class='form'>
                <label>
                    Имя:
                    <input required class='authentication' type='text' maxlength='50'>
                </label>
                <label>
                    Почта:
                    <input required class='authentication' type='text' maxlength='40'>
                </label>
                <label>
                    Пароль:
                    <input required class='authentication' type='text' maxlength='20'>
                </label>
                <button class='auth-button' type='submit'>Зарегистрироваться</button>
            </form>";
        } else {
            header("Location: /");
            exit;
        }
    ?>
</div>