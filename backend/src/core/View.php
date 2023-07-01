<?php

namespace Aruka\Core;

class View
{
    public array $params;
    public string $path;
    public string $layout = 'default';

    public function __construct(array $params)
    {
        $folder_controller = lcfirst(str_replace('Controller', '', $params['controller']));
        $folder_action = lcfirst(str_replace('Action', '', $params['action']));
        $this->path = "{$folder_controller}/{$folder_action}";
    }

    public function render($vars): void
    {
        extract($vars);
        $path = VIEWS . "/{$this->path}.php";
        if (file_exists($path)) {
            ob_start();
            require_once $path;
            $content = ob_get_clean();
            require_once LAYOUTS . "/{$this->layout}.php";
        }
    }
}
