<nav>
    <ul class="menu">
        <a href="/"><img src="logo.png" alt="Логотип"></a>
        <?php 
            if ($_SESSION['login'] === NULL) {
                echo "<li><a href='/authorization'>Вход</a></li>";
                echo "<li><a href='/registration'>Регистрация</a></li>";
            }
            else {
                echo "<li><a href='/logout'>Выход</a></li>";
            }
        ?>
    </ul>
</nav>