<div class="authorization">
    <?php 
        if ($_SESSION['login'] === 'no') {
            echo "<h2>Авторизация</h2>
            <form id='auth-form' action='/auth' class='form' method='POST'>
                <label>
                    Почта:
                    <input required class='authentication' type='email' maxlength='40' name='mail'>
                </label>
                <label>
                    Пароль:
                    <input required class='authentication' type='password' maxlength='20' name='password'>
                </label>
                <button class='auth-button' type='submit'>Авторизироваться</button>
                <p id='error-message'></p>
            </form>";
        } else {
            header("Location: /");
            exit;
        }
    ?>
</div>