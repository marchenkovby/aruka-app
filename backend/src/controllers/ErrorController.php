<?php

namespace Aruka\Controllers;

use Aruka\Core\Controller;

class ErrorController extends Controller
{
    public function index(): void
    {
        echo 'Error page';
    }

    public function page404(string $message): void
    {
        echo $message;
    }
}
