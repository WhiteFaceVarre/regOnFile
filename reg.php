<?php
session_start();

//Валидация данных регистрации
$errors = [];
//Фамилия
if (isset($_POST['user_sur_name'])) {
    $userSurname = $_POST['user_name'];
    if (!preg_match('/^[а-яёА-ЯЁ\s]+$/u', $userSurname)) {
        $user_surname_char_err = "Некорректная фамилия: Фамилия должна содержать только русские буквы, без символов.";
        array_push($errors, $user_surname_char_err);
    }
}
else {
    $user_surname_unset_err = "Некорректная фамилия: Фамилия не введена.";
    array_push($errors, $user_surname_unset_err);
}
//Имя
if (isset($_POST['user_name'])) {
    $userName = $_POST['user_name'];
    if (!preg_match('/^[а-яёА-ЯЁ\s]+$/u', $userName)) {
        $user_name_char_err = "Некорректное имя: Имя должно содержать только русские буквы, без символов.";
        array_push($errors, $user_name_char_err);
    }
}
else {
    $user_name_unset_err = "Некорректное имя: Имя не введено.";
    array_push($errors, $user_name_unset_err);
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
if (isset($_POST['user_phone_number'])) {
    $phoneNumber = $_POST['user_phone_number'];
    if(!preg_match("/^[0-9]{10,11}+$/", $phoneNumber)) {
        $user_phone_number_error = "Некорректный номер телефона: Присутствуют иные символы или некорректная длина номера.";
        array_push($errors, $user_phone_number_error);
    }
    else if ($phoneNumber[0] != 7) {
        $user_phone_first_num_err = "Некорректный номер телефона: Первая цифра должна быть 7.";
        array_push($errors, $user_phone_first_num_err);
    }
}
else {
    $user_phone_unset_err = "Некорректный номер телефона: Номер не введен.";
}
//Почта
if (isset($_POST['user_email'])) {
    $email = $_POST['user_email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $user_email_struct_err = "Некорректный адрес электронной почты: Неверная структура адреса.";
        array_push($errors, $user_email_struct_err);
    }
}
else {
    $user_email_unset_err = "Некорректный адрес электронной почты: Почта не введена.";
}
//Пароль
if (isset($_POST['user_password'])) {
    $password = urlencode($_POST['user_password']);
    $salt_crypt = md5($password);
    $password_crypt = crypt($password, $salt_crypt);
    if (strlen($password) < 8) {
        $user_password_len_err = "Некорректный пароль: Пароль должен содержать не менее 8 символов.";
        array_push($errors, $user_password_len_err);
    }
}
else {
    $user_password_unset_err = "Некорректный пароль: Пароль не введен.";
}

if (count($errors) !== 0) {
    $_SESSION['errors'] = $errors;
    header("Location: views/index.php");
}
else {
    $document_lines = file("./db/users.txt");          
    $lastUser = end($document_lines);           
    preg_match('/ID:\s*(\d+)\b/', $lastUser, $lastUserId);         
    $currentUserId = (int)$lastUserId[1] + 1;
                    
    $user_data = PHP_EOL . 'ID: ' . $currentUserId . ' | Name: ' . $userName . ' | Phone Number: ' . $phoneNumber . ' | Email: ' . $email . ' | Password: ' . $password_crypt;           
    file_put_contents("./db/users.txt", $user_data, FILE_APPEND);
}



