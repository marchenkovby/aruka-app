<?php

namespace Aruka\Controllers;

use Aruka\Core\Controller;

class ArticlesController extends Controller
{
    public function indexAction(): void
    {
        $vars = [
            'pageTitle' => 'Page with all articles',
        ];
        $this->view->render($vars);
    }

    public function showAction(): void
    {
        $vars = [
            'pageTitle' => 'Page with 1 article',
            'pageId' => $this->params['matches']['id'],
        ];
        $this->view->render($vars);
    }

    public function editAction(): void
    {
        $vars = [
            'pageTitle' => 'Edit page with article',
        ];
        $this->view->render($vars);
    }

    public function updateAction(): void
    {
        $vars = [
            'pageTitle' => 'Update page with article',
        ];
        $this->view->render($vars);
    }

    public function deleteAction(): void
    {
        $vars = [
            'pageTitle' => 'Delete page with article',
        ];
        $this->view->render($vars);
        ;
    }
}
