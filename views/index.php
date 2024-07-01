<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="./styles/reg.css">
</head>
<h2>Регистрация</h2>
<body>
    <form action="../registration.php" method="post">
        <label for="user_sur_name">Фамилия:
            <input type="text" name="user_sur_name"><br>
        </label>
        <br>
        <label for="user_name">Имя:
            <input type="text" name="user_name"><br>
        </label>
        <br>
        <label for="user_father_name">Отчество:
            <input type="text" name="user_father_name"><br>
        </label>
        <br>
        <label for="user_phone_number">Номер телефона:
            <input type="text" name="user_phone_number">
        </label>
        <br>
        <label for="user_email">Электронная почта:
            <input type="email" name="user_email">
        </label>
        <br>
        <label for="user_password">Пароль:
            <input type="password" name="user_password">
        </label>
        <br>
        <input class="sign_up" type="submit" value="Зарегистрироваться">
    </form>
    <a href="../views/auth.php">Есть аккаунт? Войти!</a>

    <div class="errors_div">
        <br><h2>Ошибка регистрации</h2><br>
        <?php
        foreach($_SESSION['errors'] as $value) {
            echo $value . "<br>";
        }
        unset($_SESSION['errors']);
        ?>
    </div>

</body>
</html>