<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../lib/model.php';
session_start();

$user_ip = $_SERVER['REMOTE_ADDR'];
if (!isset($_SESSION['failed_login_attempts'])) {
    $_SESSION['failed_login_attempts'] = [];
}

if (!isset($_SESSION['failed_login_attempts'][$user_ip])) {
    $_SESSION['failed_login_attempts'][$user_ip] = 0;
}

$max_attempts = 10;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $action = $_POST['action'];

    $model = new Model();

    if (!empty($email) && !empty($password)) {
        if ($action === 'login' && $_SESSION['failed_login_attempts'][$user_ip] >= $max_attempts) {
            die("You have exceeded the maximum number of login attempts. Please wait before trying again.");
        }

        if ($action === 'register') {
            if ($model->userExists($email)) {
                header('Location: login.php?error=emailinuse');
                exit();
            }
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            if ($model->addUser($email, $hashedPassword)) {
                header('Location: login.php?success=registration');
                exit();
            } else {
                header('Location: login.php?error=registrationfailed');
                exit();
            }
        } elseif ($action === 'login') {
            $user = $model->checkUserCredentials($email, $password);
            if ($user) {
                $_SESSION['logged_in_as'] = $user['id'];
                $_SESSION['user_email'] = $email;
                $_SESSION['failed_login_attempts'][$user_ip] = 0;
                header('Location: index.php');
                exit();
            } else {
                $_SESSION['failed_login_attempts'][$user_ip]++;
                header('Location: login.php?error=invalidcredentials');
                exit();
            }
        }
    } else {
        header('Location: login.php?error=emptyfields');
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}
