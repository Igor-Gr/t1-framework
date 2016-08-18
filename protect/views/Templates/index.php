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
