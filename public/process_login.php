<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../lib/model.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $model = new Model();
    $user = $model->checkUserCredentials($email, $password);

    if ($user) {
        $_SESSION['logged_in_as'] = $user['id'];
        $_SESSION['user_email'] = $email;

        header('Location: index.php');
        exit();
    } else {
        header('Location: login.php?error=invalidcredentials');
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}
