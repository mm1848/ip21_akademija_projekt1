<?php

require_once 'vendor/autoload.php';

$loader = new Twig\Loader\FilesystemLoader('lib/view/web');
$twig = new Twig\Environment($loader);

echo $twig->render('about.twig');