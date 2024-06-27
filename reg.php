<?php

$userName = $_POST['user_name'];
$phoneNumber = $_POST['user_phone_number'];
$email = $_POST['user_email'];
$password = $_POST['user_password'];

$document_lines = file("./db/users.txt");

$lastUser = end($document_lines);

preg_match('/ID:\s*(\d+)\b/', $lastUser, $lastUserId);

$currentUserId = (int)$lastUserId[1] + 1;

$user_data = "\n" . 'ID: ' . $currentUserId . ' | Name: ' . $userName . ' | Phone Number: ' . $phoneNumber . ' | Email: ' . $email . ' | Password: ' . $password;

file_put_contents("./db/users.txt", $user_data, FILE_APPEND);