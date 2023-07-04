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

    public function __construct()
    {
        $this->dispatch();
    }

    // Регистрирует маршрут для HTTP-метода GET
    public static function get(string $route, string $controller): void
    {
        $route = self::replaceRouteRegex($route);
        self::$routes['GET'][$route] = $controller;
    }

    // Регистрирует маршрут для POST-метода DELETE
    public static function post(string $route, string $controller): void
    {
        $route = self::replaceRouteRegex($route);
        self::$routes['POST'][$route] = $controller;
    }

    // Регистрирует маршрут для HTTP-метода PUT
    public static function put(string $route, string $controller): void
    {
        $route = self::replaceRouteRegex($route);
        self::$routes['PUT'][$route] = $controller;
    }

    // Регистрирует маршрут для HTTP-метода DELETE
    public static function delete(string $route, string $controller): void
    {
        $route = self::replaceRouteRegex($route);
        self::$routes['DELETE'][$route] = $controller;
    }

    // Регистрирует маршрут для HTTP-метода PATCH
    public static function patch(string $route, string $controller): void
    {
        $route = self::replaceRouteRegex($route);
        self::$routes['PATCH'][$route] = $controller;
    }

    // Заменяет маршрут на регулярное выражение
    public static function replaceRouteRegex(string $route): string
    {
        // Шаблоны для замены части маршрута на регулярное выражение
        $patterns = [
            '/{id}/' => '(?P<id>\d+)',
            '/\//' => '\/',
            '/{api_version}/' => 'v(?P<api_version>.{1,2})',
        ];

        // Заменяет часть маршрута на регулярное выражение,
        // если есть совпадение с шаблоном $patterns
        foreach ($patterns as $pattern => $regex) {
            if (preg_match($pattern, $route)) {
                $route = preg_replace($pattern, $regex, $route);
            }
        }

        // Возвращает маршрут с добавлением символов регулярного выражения
        // начала /^ и конца $/ строки совпадения (для точного совпадения)
        return '/^' . $route . '$/';
    }

    // Ищет совпадения между URI, полученным от пользователя,
    // и существующим зарегистрированным маршутом
    private function isMatchedUri(string $uri, string $method): bool
    {
        // Проверяет существует ли HTTP-метод, полученный от пользователя
        // в зарегстрированных маршрутах
        if (!array_key_exists($method, self::$routes)) {
            return false;
        }

        // Ищет совпадения между URI и HTTP-методом, полученным от пользователя, и
        // зарегистрированным маршрутам. Если совпадение найдено, то вызывает
        // контроллер с нужным экшином
        foreach (self::$routes[$method] as $route => $controller) {
            if (preg_match($route, $uri, $matches)) {
                list($this->params['controller'], $this->params['action']) = explode('@', $controller);
                // Проверяет если в URI, полученным от пользователя,
                // существует id, то записывает id в параметры маршрута
                if (isset($matches['id'])) {
                    $this->params['id'] = $matches['id'];
                }
                // Проверяет если в URI, полученным от пользователя,
                // существует api_version, то записывает api_version в параметры маршрута
                if (isset($matches['api_version'])) {
                    $this->params['api_version'] = $matches['api_version'];
                }
                return true;
            }
        }
        return false;
    }

    // Диспетчер вызывает нужный контроллер и экшин
    private function dispatch(): void
    {
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $method = $_SERVER['REQUEST_METHOD'];
        if ($this->isMatchedUri($uri, $method)) {
            $this->callAction($this->params['controller'], $this->params['action']);
            return;
        }
        throw new Exception("No route defined for URI: {$uri}, method: {$method}");
    }

    // Вызывает экшин контроллера
    private function callAction($controller, $action): void
    {
        $controller = 'Aruka\\Controllers\\' . $controller;
        if (class_exists($controller)) {
            $controller = new $controller($this->params);
            if (method_exists($controller, $action)) {
                $controller->$action();
            } else {
                throw new Exception("Action {$action} not found");
            }
        } else {
            throw new Exception("Controller {$controller} not found");
        }
    }
}
