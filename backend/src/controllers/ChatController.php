<?php

namespace Aruka\Controllers;

use Aruka\Core\Controller;

class ChatController extends Controller
{
    public function indexAction(): void
    {
        $vars = [
            'pageTitle' => 'Chat page',
        ];
        $this->view->render($vars);
    }
}
