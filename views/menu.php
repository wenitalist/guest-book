<nav>
    <ul class="menu">
        <a href="/"><img src="logo.png" id='logo-image' alt="Логотип"></a>
        <?php 
            if ($_SESSION['login'] === 'no') {
                echo "<li><a class='authorization-link' href='/authorization'>Вход</a></li>
                      <li><a class='registration-link' href='/registration'>Регистрация</a></li>";
            }
            else {
                echo "<li><a class='logout-link' href='/logout'>Выход</a></li>";
            }
        ?>
    </ul>
</nav>