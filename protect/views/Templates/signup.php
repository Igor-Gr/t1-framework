<ul class="nav nav-tabs">
    <li role="presentation"><a href="/index/default">Главная</a></li>
    <li role="presentation" class="active"><a href="/index/signup">Регестрция</a></li>
    <li role="presentation"><a href="#">Messages</a></li>
</ul>

<?= $error; ?>

<div class="container">
    <div class="row">
        <a href="/index/default" style='float:right'>Назад</a>
        <form action="/index/signup" method="post">
            <p>
                <strong>Ваш логин</strong><br><br>
                <input type="text" name="login" value="<?= $data['login'] ?>">
            </p>
            <p>
                <strong>Ваш Email</strong><br><br>
                <input type="text" name="email" value="<?= $data['email'] ?>">
            </p>
            <p>
                <strong>Ваш пароль</strong><br><br>
                <input type="password" name="password">
            </p>
            <p>
                <strong>Повторите пароль</strong><br><br>
                <input type="password" name="password_2">
            </p>
            <p>
                <button id="btn">Зарегестрироваться</button>
            </p>
        </form>
    </div>
</div>


