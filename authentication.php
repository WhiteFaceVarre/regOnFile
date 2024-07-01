<?php
session_start();

$data = [];

foreach ($_POST as $key => $value) {
    $data[$key] = strip_tags(trim($value));
}

$phoneNumber = $data['user_phone_number'];
$password = $data['user_password'];

$users = file("./db/users.txt");
$errors = [];

if (isset($phoneNumber)) {
    if (!preg_match("/^[0-9]{10,11}+$/", $phoneNumber)) {
        $errors[] = 'Некорректный номер телефона: Присутствуют иные символы или некорректная длина номера.';
    } else if ($phoneNumber[0] != 7) {
        $errors[] = 'Некорректный номер телефона: Первая цифра должна быть 7.';
    }
} else {
    $errors[] = "Некорректный номер телефона: Номер не введен.";
}
if (isset($password)) {
    if (strlen($password) < 8) {
        $errors[] = 'Некорректный пароль: Пароль должен содержать не менее 8 символов.';
    }
} else {
    $errors[] = 'Некорректный пароль: Пароль не введен.';
}

if (empty($users[1])) {
    $errors[] = 'Не существует ни одного пользователя';
} else {
    define($USER_PHONE_LENGTH, 11);
    foreach($i = 1; $i < count($users); $i++) {
        $findUser = substr($users[$i], '7', $USER_PHONE_LENGTH);
        if ($phoneNumber != $findUser) {
            $errors[] = 'Пользователь не найден.';
            break;
        } else {
            $currentUserId = $i - 1;
            break;
            
            $hashPosition = strrpos($users[$currentUserId], '|');
        }
    }
}

if (count($errors) !== 0) {
    $_SESSION['errors'] = $errors;
    header('Location: views/index.php');
} else {
    $_SESSION['userName'] = $userName;
    header('Location: views/main.php');

    

    //хэширование пароля через адекватную функцию
    $passwordCrypt = password_hash($password, PASSWORD_DEFAULT);
    $user_data = $currentUserId . '|' . $userSurname . '|' . $userName . '|' . $userFatherName . '|' . $phoneNumber . '|' . $email . '|' . $passwordCrypt . PHP_EOL;
    file_put_contents('./db/users.txt', $user_data, FILE_APPEND);
}