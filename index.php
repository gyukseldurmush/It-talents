<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();


$controllerName = isset($_GET["target"]) ? $_GET["target"] : "main";
$methodName = isset($_GET["action"]) ? $_GET["action"] : "render";


$controllerClassName = "\\Controller\\" . ucfirst($controllerName) . "Controller";
spl_autoload_register(function ($class){
    require_once str_replace("\\", DIRECTORY_SEPARATOR, $class) . ".php";
});


if (class_exists($controllerClassName)){
    $controller = new $controllerClassName();

    if(method_exists($controller, $methodName)){
        try{
            $controller->$methodName();
        }catch (Exception $exception){
            echo "error -> " . $exception->getMessage();
            die();
        }
    }else{
        echo "error: method not found: $controllerClassName -> $methodName\n";
        die();
    }

    exit();
}else{
    echo "error: controller not found $controllerClassName\n";
    die();
}
