<?php

$userName = $_POST['user_name'];
$phoneNumber = $_POST['user_phone_number'];
$email = $_POST['user_email'];

$password = urlencode($_POST['user_password']);

if (strlen($userName) == 0 || strlen($userName) < 16) {
    echo "Короткое имя: ФИО не должно содержать менее 16 символов.";
}
else if (!preg_match('/^[а-яёА-ЯЁ\s]+$/u', $userName)) {
    echo "Некорректное имя: ФИО должно содержать только русские буквы, без символов.";
}
else {
    if(!preg_match("/^[0-9]{10,11}+$/", $phoneNumber)) {
        echo "Неправильный номер телефона: присутствуют иные символы или некорректная длина номера.";
    }
    else if ($phoneNumber[0] != 7) {
        echo "Неправильный номер телефона: первая цифра должна быть 7.";
    }
    else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Некорректный адрес электронной почты: неверная структура адреса.";
        }
        else {
            if (strlen($password) < 8) {
                echo "Некорректный пароль: пароль должен содержать не менее 8 символов.";
            }
            else {
                $salt_crypt = md5($password);
                $password_crypt = crypt($password, $salt_crypt);
                
                $document_lines = file("./db/users.txt");
                
                $lastUser = end($document_lines);
                
                preg_match('/ID:\s*(\d+)\b/', $lastUser, $lastUserId);
                
                $currentUserId = (int)$lastUserId[1] + 1;
                
                $user_data = "\n" . 'ID: ' . $currentUserId . ' | Name: ' . $userName . ' | Phone Number: ' . $phoneNumber . ' | Email: ' . $email . ' | Password: ' . $password_crypt;
                
                file_put_contents("./db/users.txt", $user_data, FILE_APPEND);
            }
        }
    }
}

