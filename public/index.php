<?php
use Shop\src\Application;
use Shop\entities\Product;
use Shop\entities\Cart;
use Shop\entities\Order;

//General settings
ini_set('display_errors',1);
error_reporting(E_ALL | E_STRICT);
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);

//require system files
require '../vendor/autoload.php';
require APP . 'config/config.php';

//define route
$url = trim(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL), '/');

//application launch
$app = new Application(new Product(), new Cart(), new Order());
$app->run($url);




