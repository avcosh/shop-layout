<?php
ini_set('display_errors', 1);
require_once('./php/db/Database.php');
$d = new Database();
$d->setCart($_REQUEST);
$r = $d->makeOrder($_REQUEST);
if ($r == 0)
{
    header('Created', true, 201);
} else {
    header('Bad request', true, 400);
}