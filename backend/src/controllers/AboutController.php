<?php

namespace Aruka\Controllers;

use Aruka\Core\Controller;

class AboutController extends Controller
{
    public function indexAction()
    {
        $this->view->render([
            'pageTitle' => 'About page',
        ]);
    }
}
