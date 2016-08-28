<ul class="nav nav-tabs">
    <li role="presentation"><a href="/index/default">Главная</a></li>
    <li role="presentation"><a href="/index/signup">Регестрция</a></li>
    <li role="presentation" class="active"><a href="/index/login">Авторизация</a></li>
</ul>
<p class="bg-danger"><?= $error; ?></p>
<p class="bg-success"></p>

<?php if (isset($_SESSION['logged_user'])) : ?>
    <a href="/index/out">Выйти</a>
<?php else : ?>

<div class="container">
    <a href="/index/default" style='float:right'>Назад</a>
    <h1 style="margin-bottom: 200px">Авторизация</h1>

    <form action="/index/login" method="post" class="form-horizontal">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Логин</label>
            <div class="col-sm-10">
                <input type="text" name="login" class="form-control" id="inputEmail3" placeholder="Логин">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
            <div class="col-sm-10">
                <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Пароль">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Запомнить меня
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" name="auth" class="btn btn-primary">Войти</button>
            </div>
        </div>
    </form>
</div>

<?php endif; ?>