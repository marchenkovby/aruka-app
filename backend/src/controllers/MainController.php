<?php

namespace Aruka\Controllers;

use Aruka\Core\Controller;

class MainController extends Controller
{
    protected $db;

    public function indexAction(): void
    {
        $this->view->render([
            'pageTitle' => 'Main page',
        ]);
    }
}
