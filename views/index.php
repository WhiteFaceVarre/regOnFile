<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="./styles/reg.css">
</head>
<h2>Регистрация</h2>
<body>
    <form action="../reg.php" method="post">
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

    <div class="errors_div">
        <br><h2>Ошибка регистрации</h2><br>
        <?php
        for($i = 0; $i < count($_SESSION['errors']); $i++) {
            echo $_SESSION['errors'][$i];
        }
        ?>
    </div>

</body>
</html>