<?php

namespace Aruka\Core;

abstract class Controller
{
    public array $params;
    public object $view;
    public $render;

    public function __construct($params)
    {
        $this->params = $params;
        $this->view = new View($params);
    }
}
