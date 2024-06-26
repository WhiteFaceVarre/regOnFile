<?php
$user_name = $_POST['user_name'];
$phone_number = $_POST['user_phone_number'];
$email = $_POST['user_email'];
$password = $_POST['user_password'];

$users_db_read = fopen("./db/users.txt", "a+");

$db_file = file_get_contents("./db/users.txt");
$document_lines = explode("\n", $db_file);
$len = count($document_lines) - 1;

$last_line_document = $document_lines[$len];
$first_char_search = ":";
$second_char_search = "|";

$index_first_char = stripos($last_line_document, $first_char_search);
$index_second_char = stripos($last_line_document, $second_char_search);

$id = "";

for($k = 0, $i = $index_first_char + 2, $j = $index_second_char - 1; $i < $j; $k++, $i++) {
    $id[$k] = $last_line_document[$i];
}

$id = +$id;
var_dump($id);

fclose($users_db_read);

$id++;

$user_data = "\n" . "ID: " . $id . " | Name: " . $user_name . " | Phone Number: " . $phone_number . " | EMail: " . $email . " | Password: " . $password;


$users_db_write = fopen("./db/users.txt", "a");

fwrite($users_db_write, $user_data);

fclose($users_db_write);