<?php

namespace Vayu\Controllers;

class TestController
{
    public function __construct()
    {
        echo "This is " . __CLASS__ . "<br /> \n ";
    }

    public function display(): void
    {
        echo 'This is ' . __FUNCTION__ . ' at class ' . __CLASS__ . "<br /> \n ";
    }

}