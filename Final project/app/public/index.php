<?php
header("Access-Control-Allow-Origin: *");
require __DIR__ . '/../patternrouter.php';
require __DIR__ . '/../switchrouter.php';
$uri = trim($_SERVER['REQUEST_URI'], '/');

$router = new PatternRouter();
$router->route($uri);