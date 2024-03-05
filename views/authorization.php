<div class="authorization">
    <?php 
        if ($_SESSION['login'] === 'no') {
            echo "<h2>Авторизация</h2>
            <form id='auth-form' action='/auth' class='form' method='POST'>
                <label>
                    Почта:
                    <input required id='inputMail' class='authentication' type='email' maxlength='40' name='mail'>
                </label>
                <label>
                    Пароль:
                    <input required id='inputPassword' class='authentication' type='password' maxlength='20' name='password'>
                </label>
                <label style='display:none'> <!-- Защита от ботов -->
                    Фамилия:
                    <input type='text' name='secondName' tabindex='-1'>
                </label>
                <button class='auth-button' type='submit'>Авторизоваться</button>
                <p id='error-message'></p>
            </form>";
        } else {
            header("Location: /");
            exit;
        }
    ?>
</div>