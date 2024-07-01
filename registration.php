<?php
session_start();

//массив с данными пользователя
$data = [];

//возвращаем в массив данные без пробелов с обех сторон и без тегов
foreach ($_POST as $key => $value) {
    $data[$key] = strip_tags(trim($value));
}

//помещение данных массива по ключам в переменные
$userSurname = $data['user_sur_name'];
$userName = $data['user_name'];
$userFatherName = $data['user_father_name'];
$phoneNumber = $data['user_phone_number'];
$email = $data['user_email'];
$password = $data['user_password'];

//хранение данных лог-файла в переменной
$users = file("./db/users.txt");

//Валидация данных регистрации
$errors = [];
//Фамилия
if (isset($userSurname)) {
    if (!preg_match('/^[а-яёА-ЯЁ\s]+$/u', $userSurname)) {
        $errors[] = 'Некорректная фамилия: Фамилия должна содержать только русские буквы, без символов.';
    }
} else {
    $errors[] = 'Некорректная фамилия: Фамилия не введена.';
}
//Имя
if (isset($userName)) {
    if (!preg_match('/^[а-яёА-ЯЁ\s]+$/u', $userName)) {
        $errors[] = 'Некорректное имя: Имя должно содержать только русские буквы, без символов.';
    }
} else {
    $errors[] = 'Некорректное имя: Имя не введено.';
}
//Отчество
if (isset($_POST['user_father_name'])) {
    $userFatherName = $_POST['user_name'];
    if (!preg_match('/^[а-яёА-ЯЁ\s]+$/u', $userFatherName)) {
        $user_father_name_char_err = "Некорректное имя: Имя должно содержать только русские буквы, без символов.";
        array_push($errors, $user_father_name_char_err);
    }
}
//Номер телефона
if (isset($phoneNumber)) {
    if (!preg_match("/^[0-9]{10,11}+$/", $phoneNumber)) {
        $errors[] = 'Некорректный номер телефона: Присутствуют иные символы или некорректная длина номера.';
    } else if ($phoneNumber[0] != 7) {
        $errors[] = 'Некорректный номер телефона: Первая цифра должна быть 7.';
    }
} else {
    $errors[] = "Некорректный номер телефона: Номер не введен.";
}
//Почта
if (isset($email)) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Некорректный адрес электронной почты: Неверная структура адреса.';
    }

    foreach ($users as $key => $value) {
        if ($key === 0) {
            continue;
        }

        $userData = explode('|', $value);
        if ($userData[5] === $email) {
            $errors[] = 'Такая почта уже существует';
            break;
        }
    }
} else {
    $errors[] = 'Некорректный адрес электронной почты: Почта не введена.';
}
//Пароль
if (isset($password)) {
    if (strlen($password) < 8) {
        $errors[] = 'Некорректный пароль: Пароль должен содержать не менее 8 символов.';
    }
} else {
    $errors[] = 'Некорректный пароль: Пароль не введен.';
}

if (count($errors) !== 0) {
    $_SESSION['errors'] = $errors;
    header('Location: views/index.php');
} else {
    $_SESSION['userName'] = $userName;
    header('Location: views/main.php');

    if (empty($users[0])) {
        $first_line_data = 'ID | Surname | Name | Fathername | Phone Number | EMail | Password' . PHP_EOL;
        file_put_contents('./db/users.txt', $first_line_data, FILE_APPEND);
    }

    if (empty($users[1])) {
        $currentUserId = 0;
    } else {
        $lastUser = end($users);
        $lastUserId = explode('|', $lastUser)[0];
        $currentUserId = (int)$lastUserId + 1;
    }

    //хэширование пароля через адекватную функцию
    $passwordCrypt = password_hash($password, PASSWORD_DEFAULT);
    $user_data = $currentUserId . '|' . $userSurname . '|' . $userName . '|' . $userFatherName . '|' . $phoneNumber . '|' . $email . '|' . $passwordCrypt . PHP_EOL;
    file_put_contents('./db/users.txt', $user_data, FILE_APPEND);
}



