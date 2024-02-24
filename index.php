<?php

require_once 'vendor/autoload.php';
require_once 'lib/model.php';

$loader = new Twig\Loader\FilesystemLoader('lib/view/web');
$twig = new Twig\Environment($loader);

$model = new Model();

$allCurrencies = $model->getAllCurrencies();

if ($allCurrencies === null) {
    echo "Error retrieving currencies.";
    exit;
}

echo $twig->render('select_currencies.html.twig', ['currencies' => $allCurrencies['data']]);




