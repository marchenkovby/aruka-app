<?php

namespace Aruka\Core;

abstract class Controller
{
    public array $paramsRoute = [];

    public function __construct($paramsRoute)
    {
        $this->paramsRoute = $paramsRoute;
        $this->view = new View($paramsRoute);
    }
}
