<?php

// Режим разработки, true - включен, false - выключен
define('DEBUG', true);

// Директория с файлами фреймворка
define('ROOT', dirname(__DIR__));

// Директория с файла ядра фреймворка
define('CORE', dirname(__DIR__) . '/core');

// Директория с файлами конфигурации фреймворка
define('CONFIG', dirname(__DIR__) . '/config');

// Директория с логами
define('LOGS', dirname(__DIR__) . '/../logs');

// Директория с контроллерами
define('CONTROLLERS', dirname(__DIR__) . '/controllers');

// Директория с моделями
define('MODELS', dirname(__DIR__) . '/models');

// Директория с представлениями
define('VIEWS', dirname(__DIR__) . '/views');

// Директория с шаблонами
define('LAYOUTS', VIEWS . '/layouts');

// Директория с файлами для теста
define('TESTS', dirname(__DIR__) . '/../tests');
