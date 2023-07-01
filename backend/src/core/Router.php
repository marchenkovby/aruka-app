<?php

declare(strict_types=1);

namespace Aruka\Core;

use Exception;

class Router
{
    // Зарегистрированные маршруты
    public static array $routes = [];

    // Параметры для зарегистрированного маршрута
    public array $params = [];

    private function __construct()
    {
    }

    // Создает и запускает маршрутизатор
    public static function run(): void
    {
        $instance = new Router();
        $instance->direct();
    }

    // Добавляет маршруты из файла в зарегистрированные маршруты
    public static function addRoute(string $method, string $route, string $controller): void
    {
        $route = self::addRegexRoute($route);
        self::$routes[$method][$route] = $controller;
    }

    // Заменяет маршруты на регулярные выражения
    public static function addRegexRoute(string $route): string
    {
        // Шаблоны для замены маршрута на регулярное выражение
        $patternsRoute = [
            '/{id}/' => '(?P<id>\d+)',
            '/\//' => '\/',
        ];

        // Заменяет маршрут на регулярное выражение выражения,
        // если есть совпадение с шаблоном $patternsRoute
        foreach ($patternsRoute as $patternRoute => $patternRegex) {
            if (preg_match($patternRoute, $route)) {
                $route = preg_replace($patternRoute, $patternRegex, $route);
            }
        }

        // Возвращает маршрут с добавлением символов регулярного выражения
        // начала /^ и конца $/ строки совпадения (для точного совпадения)
        return '/^' . $route . '$/';
    }

    // Ищет совпадения между URI, полученным от пользователя,
    // и существующим маршутом из свойства routes
    private function isMatchedUri(string $requestUri, string $requestMethod): bool
    {
        foreach (self::$routes[$requestMethod] as $route => $controller) {
            if (preg_match($route, $requestUri, $matches)) {
                list($this->params['controller'], $this->params['action']) = explode('@', $controller);
                $this->params['matches'] = $matches;
                return true;
            }
        }
        return false;
    }

    // Вызывает контроллер и экшин в зависимости от URI и метода, полученного от пользователя
    private function direct(): void
    {
        $requestUri = trim($_SERVER['REQUEST_URI'], '/');
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($this->isMatchedUri($requestUri, $requestMethod)) {
            $this->callAction($this->params['controller'], $this->params['action']);
            return;
        }

        throw new Exception("No route defined for this URI");
    }

    // Вызывает экшин контроллера
    private function callAction($controller, $action)
    {
        $controller = 'Aruka\\Controllers\\' . $controller;
        if (class_exists($controller)) {
            $controller = new $controller($this->params);
            if (method_exists($controller, $action)) {
                $controller->$action();
            } else {
                throw new \Exception("Action {$action} not found");
            }
        } else {
            throw new Exception("Controller {$controller} not found");
        }
    }
}
