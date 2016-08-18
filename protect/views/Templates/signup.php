
<a href="/register/main" style='float:right'>Назад</a>
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
