<?php

namespace Vayu\Controllers;

class DemoController
{
    public function __construct()
    {
        echo 'Just constructor of DemoController is called';
    }

    public function __destruct()
    {
        echo 'Just destruct of DemoController is called';
    }

}