<?php

namespace Aruka\Core;

class View
{
    public array $params = [];
    public string $path = '';
    public string $layout = 'default';

    public function __construct(array $params)
    {
        $folderController = lcfirst(str_replace('Controller', '', $params['controller']));
        $folderAction = lcfirst(str_replace('Action', '', $params['action']));
        $this->path = "{$folderController}/{$folderAction}";
    }

    public function renderPage($data): void
    {
        extract($data);
        $path = VIEWS . "/{$this->path}.php";
        if (file_exists($path)) {
            ob_start();
            require_once $path;
            $content = ob_get_clean();
            require_once LAYOUTS . "/{$this->layout}.php";
        }
    }

    public function renderApi($data): void
    {
        // Преобразует данные в формат JSON
        $json = json_encode($data);

        // Устанавливает заголовок для указания типа контента
        header('Content-Type: application/json');

        // Выводит JSON на экран
        echo $json;
    }
}
