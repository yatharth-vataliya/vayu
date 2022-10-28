<?php

namespace Vayu\Controllers;


use Vayu\Request;

class DemoController
{
    public function __construct(private TestController $testController)
    {
        echo 'Just constructor of DemoController is called' . "<br /> \n ";
    }

    public function callDemoControllersDisplayMethod(Request $request): void
    {
//        echo "Just printing Id first ". $id . "\n";
        var_dump($request);
        $this->testController->display();
    }

    public function __destruct()
    {
        echo 'Just destruct of DemoController is called' . "<br /> \n ";
    }

    public function callDemoControllersMethodWithDI(Request $request) : object
    {
        var_dump($request);
        return $request;
    }

}