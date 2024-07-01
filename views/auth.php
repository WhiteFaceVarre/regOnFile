<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
</head>
<body>
<form action="../authentication.php" method="post">
        <label for="user_phone_number">Номер телефона:
            <input type="text" name="user_phone_number">
        </label>
        <br>
        <label for="user_password">Пароль:
            <input type="password" name="user_password">
        </label>
        <br>
        <input class="sign_in" type="submit" value="Войти">
    </form>
    <a href="../views/index.php">Нет аккаунта? Зарегистрироваться!</a>
</body>
</html>