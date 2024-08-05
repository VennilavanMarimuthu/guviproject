<?php
session_start();
require 'connection.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $mysqli->prepare("SELECT id, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        echo 'success';
    } else {
        echo 'Invalid username or password';
    }
} else {
    echo 'Invalid username or password';
}
?>