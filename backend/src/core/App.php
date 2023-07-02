<?php

namespace Aruka\Core;

class App
{
    public function __construct()
    {
        $this->init();
    }

    // Инициализирует приложение
    private function init(): void
    {
        // Подключает файл конфигурации
        $fileBootstrap =  dirname(__DIR__) . '/core/bootstrap.php';
        if (file_exists($fileBootstrap)) {
            require_once $fileBootstrap;
        }

        // Cоздает объект для собственной обработки ошибок
        new ErrorHandler();

        // Подключает файл с различными ошибками
        //require_once TESTS . '/errors.php';

        // Создает объект маршрутизатора
        new Router();
    }
}
