<?php

namespace Aruka\Controllers\API\V1;

use Aruka\Core\Controller;

class ArticlesController extends Controller
{
    public function indexAction(): void
    {
        echo 'API page with all articles', '<br>';
    }

    public function showAction(): void
    {
        echo 'API page with 1 article, id = ', $this->params['matches']['id'], '<br>';
    }
}
