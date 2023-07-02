<?php

namespace Aruka\Controllers;

use Aruka\Core\Controller;

class ArticlesController extends Controller
{
    public function indexAction(): void
    {
        $this->view->renderPage([
            'pageTitle' => 'Page with all articles',
        ]);
    }

    public function createAction(): void
    {
        $this->view->renderPage([
            'pageTitle' => 'Create page',
        ]);
    }

    public function showAction(): void
    {
        $this->view->renderPage([
            'pageTitle' => 'Page with 1 article',
            'pageId' => $this->params['id'],
        ]);
    }

    public function editAction(): void
    {
        $this->view->renderPage([
            'pageTitle' => 'Edit page with article',
        ]);
    }

    public function updateAction(): void
    {
        $this->view->renderPage([
            'pageTitle' => 'Update page with article',
        ]);
    }

    public function deleteAction(): void
    {
        $this->view->renderPage([
            'pageTitle' => 'Delete page with article',
        ]);
    }

    public function apiAction(): void
    {
        $this->view->renderApi([
            'pageTitle' => 'Page with API',
        ]);
    }
}
