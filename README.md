<h2>Развёртывание проекта локально:</h2>
<ol>
 <li>Установить LEMP</li>
 <li>Клонировать репозиторий</li>
 <li>Настроить конфиг nginx</li>
 <li>Создать пользователя и б/д в mysql</li>
 <li>Заполнить env.php</li>
 <li>Применить миграции</li>
</ol>

<h2>Команды для мигратора</h2>

Применение миграций:
<ol>
 <li>Переходим в каталог /guest-book/</li>
 <li>Вводим команду: php migrator apply</li>
</ol>

Создание новой миграции:
<ol>
 <li>Переходим в каталог /guest-book/</li>
 <li>Вводим команду: php migrator make {название-миграции}</li>
 <li>Новая миграция появится в папке migrations, в ней нужно составить запрос</li>
</ol>