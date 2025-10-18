<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
$controllerName = isset($_GET['c']) ? ucfirst($_GET['c']) . 'Controller' : 'UserController';
$methodName = isset($_GET['f']) ? $_GET['f'] : 'showLogin';
$controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';
if (!file_exists($controllerFile)) {
    die('Error: File controller tidak ditemukan.');
}
require_once $controllerFile;
if (!class_exists($controllerName)) {
    die('Error: Class controller tidak ditemukan.');
}
$controller = new $controllerName();
if (!method_exists($controller, $methodName)) {
    die('Error: Method tidak ditemukan.');
}
$controller->$methodName();
