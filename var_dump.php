<?php

require_once 'lib/model.php';

$model =new Model();

$valid_currecy_symbols = $model->getValidCurrencies();
var_dump($valid_currecy_symbols);