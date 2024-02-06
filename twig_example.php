<?php

require_once 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\ArrayLoader;

$templates = [
    'hello' => 'Hello, {{ name }}!',
    'goodbye' => 'Goodbye, {{ name }}!'
];

$loader = new ArrayLoader($templates);

$twig = new Environment($loader);

echo $twig->render('hello', ['name' => 'World']) . PHP_EOL;

echo $twig->render('goodbye', ['name' => 'Twig']) . PHP_EOL;