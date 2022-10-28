<?php

namespace Vayu;

class Request
{

    public function __construct(public $get = null, public $post = null, public $file = null, public $server = null)
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->file = $_FILES;
        $this->server = $_SERVER;

        echo 'This is class ' . __CLASS__ . ' at function ' . __FUNCTION__ . "<br /> \n";

    }

}