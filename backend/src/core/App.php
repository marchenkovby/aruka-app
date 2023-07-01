<?php

namespace Aruka\Core;

class App
{
    private function __construct()
    {
    }

    // Создает и запускает приложение
    public static function run(): void
    {
        $instance = new App();
        $instance->init();
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

        // Запускает маршрутизатор
        Router::run();
    }
}
