<div class="registration">
    <?php 
        if ($_SESSION['login'] === 'no') {
            echo "<h2>Регистрация</h2>
            <form id='auth-form' action='/regis' class='form' method='POST'>
                <label>
                    Имя:
                    <input required id='inputName' class='authentication' type='text' maxlength='50' name='name'>
                </label>
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
                <button class='auth-button' type='submit'>Зарегистрироваться</button>
                <p id='error-message'></p>
            </form>";
        } else {
            header("Location: /");
            exit;
        }
    ?>
</div>