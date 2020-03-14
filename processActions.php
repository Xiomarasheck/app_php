<?php


define('path_URL', __DIR__);

require_once path_URL . '/app/Model/Model.php';
require_once path_URL . '/app/Controllers/Controller.php';


// get data request
$getController = $_GET['controller'];
$getMethod = $_GET['method'];


// get controller name
$controller = ucwords($getController) . 'Controller';
$strFileController = path_URL . '/app/Controllers/' . $controller . '.php';
require_once $strFileController;

// instance controller
$objController = new $controller();

//call action
$objController->$getMethod();
//var_dump($objController);

