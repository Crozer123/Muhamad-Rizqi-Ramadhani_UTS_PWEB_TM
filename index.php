<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$controllerName = isset($_GET['c']) ? ucfirst($_GET['c']) . 'Controller' : 'StoreController';
$methodName = isset($_GET['f']) ? $_GET['f'] : 'index';

$controllerFile = __DIR__ . '/app/controllers/' . $controllerName . '.php';

if (!file_exists($controllerFile)) {
    die('Error: File controller tidak ditemukan. Path: ' . $controllerFile);
}
require_once $controllerFile;

if (!class_exists($controllerName)) {
    die('Error: Class controller tidak ditemukan: ' . $controllerName);
}

$controller = new $controllerName();

if (!method_exists($controller, $methodName)) {
    die('Error: Method tidak ditemukan: ' . $methodName);
}

$controller->$methodName();
?>