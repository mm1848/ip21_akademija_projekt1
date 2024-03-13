<?php

require_once __DIR__ . '/../vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../lib/view/web');
$twig = new \Twig\Environment($loader);

$successMessage = '';
if (isset($_GET['success'])) {
    $successMessage = "Registration successful. Please log in.";
}

echo $twig->render('login.twig', ['successMessage' => $successMessage]);