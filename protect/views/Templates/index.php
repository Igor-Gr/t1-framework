<ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="/index/default">Главная</a></li>
    <li role="presentation"><a href="/index/signup">Регестрция</a></li>
    <li role="presentation"><a href="#">Messages</a></li>
</ul>

<div class="container">
    <h1>Elision framework</h1>
    <?php if (isset($_SESSION['logged_user'])) : ?>
        Авторизован!
        <br>
        Привет, <?php echo $_SESSION['logged_user'] ?> <br><br> <a href="/lc/main">Личный кабинет</a>
        <hr>
        <a href="/register/out">Выйти</a>
    <?php else : ?>
        <a href="/register/login">Авторизация</a>
        <br>
        <a href="/index/signup">Регестрация</a>

    <?php endif; ?>
</div>
