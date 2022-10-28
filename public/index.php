<?php

require __DIR__ . '/../vendor/autoload.php';

use Vayu\Container;

$className = \Vayu\Controllers\DemoController::class;

$container = new Container();

$demoControllerClass = $container->get($className);

$reflectionClass = new \ReflectionClass($className);
$reflectionMethod = $reflectionClass->getMethod('callDemoControllersMethodWithDI');
$reflectionParams = $reflectionMethod->getParameters();
$dependency = [];
$dependency = array_map(function (\ReflectionParameter $param) use ($container) {
    return $container->get($param->getType()->getName());
}, $reflectionParams);
echo '<pre>';
//var_dump($dependency);

call_user_func_array([$demoControllerClass, 'callDemoControllersDisplayMethod'],[...$dependency]);

//call_user_func_array([$demoControllerClass, 'callDemoControllersMethodWithDI'], [...$dependency]);