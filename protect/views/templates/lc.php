<ul class="nav nav-tabs">
    <li role="presentation"><a href="/index/default">Главная</a></li>
    <li role="presentation"><a href="/index/signup">Регестрция</a></li>
    <li role="presentation"><a href="/index/login">Авторизация</a></li>
    <li role="presentation" class="active"><a href="/index/lc">Личный кабинет</a></li>
</ul>

<p class="bg-danger"><?= $error; ?></p>
<p class="bg-success"></p>

<div class="container">
    <h1>Личный кабинет</h1>
    <h3 style="margin-bottom: 100px">Ваш идентификатор: <?= $_SESSION['client_id']; ?></h3>
    <form action="/index/lc" method="post" enctype='multipart/form-data'>
        <div class="form-group">
            <label for="exampleInputEmail1">Заголововк</label>
            <textarea name="title" class="form-control" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Описание</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="exampleInputFile">Выберите изображение</label>
            <input type="file" name="image" id="exampleInputFile">
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox"> Запомнить
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>