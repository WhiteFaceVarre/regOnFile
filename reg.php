<?php
$user_name = $_POST['user_name'];
$phone_number = $_POST['user_phone_number'];
$email = $_POST['user_email'];
$password = $_POST['user_password'];

$user_data = "Name: " . $user_name . " | Phone Number: " . $phone_number . " | EMail: " . $email . " | Password: " . $password . "\n";

$users_db = fopen("./db/users.txt", "a+");

fwrite($users_db, $user_data);

fclose($users_db);