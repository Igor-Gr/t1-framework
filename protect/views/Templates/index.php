<ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="/Index/Default">Главная</a></li>
    <li role="presentation"><a href="/Index/Signup">Регестрция</a></li>
    <li role="presentation"><a href="/Index/Login">Авторизация</a></li>
</ul>

<div class="container">
    <h1>Elision framework</h1>
    <?php if (isset($_SESSION['logged_user'])) : ?>
        Авторизован!
        <br>
        Привет, <?php echo $_SESSION['logged_user'] ?> <br><br> <a href="/index/lc">Личный кабинет</a>
        <hr>
        <a href="/index/out">Выйти</a>
    <?php else : ?>
        <a href="/index/login">Авторизация</a>
        <br>
        <a href="/index/signup">Регестрация</a>

    <?php endif; ?>
</div>
