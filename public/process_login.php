<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../lib/model.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $action = $_POST['action'];

    $model = new Model();

    if (!empty($email) && !empty($password)) {
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
                header('Location: index.php');
                exit();
            } else {
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

