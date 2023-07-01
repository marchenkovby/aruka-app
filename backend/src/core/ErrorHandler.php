<?php

declare(strict_types=1);

namespace Aruka\Core;

use Aruka\Controllers\ErrorController;

class ErrorHandler
{
    public function __construct()
    {
        if (DEBUG) {
            // Включает отчет обо всех ошибках
            error_reporting(E_ALL);

            // Включает показ ошибок
            ini_set('display_errors', 'On');
        } else {
            // Выключает отчет обо ошибках
            error_reporting(0);

            // Выключает показ ошибок
            ini_set('display_errors', 'Off');
        }

        // Назначает собственную функцию для обработки ошибок
        set_error_handler([$this, 'errorHandler']);

        // Назначает собственную функцию для обработки исключения
        set_exception_handler([$this, 'exceptionHandler']);

        // Включает буфер вывода
        ob_start();

        // Назначает собственную функцию для фатальных ошибок
        register_shutdown_function([$this, 'fatalErrorHandler']);
    }

    // Записывает ошибку в лог
    protected function writeErrorLog(string $type = '', string $message = '', string $file = '', int $line = 0): void
    {
        $logFile = LOGS . '/errors.log';
        $logTimestamp = date('Y-m-d H:i:s');
        $logMessage = "[{$logTimestamp}] Type: {$type} | Message: {$message} | File: {$file} | Line: {$line}" . PHP_EOL;
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

    // Показывает ошибку на экран
    protected function displayError(string $type = '', string $message = '', string $file = '', int $line = 0, int $response = 500)
    {
        if ($response === 0) {
            $response = 404;
        }

        http_response_code($response);

        // $error1 = new ErrorController();

        if (!DEBUG) {
            echo '<br>', 'Mode: Production', '<br>';
            echo 'Some error', '<br>';
        } else {
            echo '<br>', 'Mode: Development', '<br>';
            echo 'Type: ', $type, '<br>';
            echo 'Message: ', $message, '<br>';
            echo 'File: ', $file, '<br>';
            echo 'Line: ', $line, '<br>';
            echo 'Response: ', $response, '<br>';
        }

        exit;
    }

    // Обрабатывает исключения
    public function exceptionHandler(\Throwable $exception)
    {
        // Вызывает метод для обработки ошибки
        $this->errorHandler(
            'EXCEPTION',
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        );
    }

    // Обрабатывает ошибку
    public function errorHandler(string $type, string $message, string $file, int $line): void
    {
        if (!empty($type)) {
            $errors = array(
                E_ERROR => 'E_ERROR',
                E_WARNING => 'E_WARNING',
                E_PARSE => 'E_PARSE',
                E_NOTICE => 'E_NOTICE',
                E_CORE_ERROR => 'E_CORE_ERROR',
                E_CORE_WARNING => 'E_CORE_WARNING',
                E_COMPILE_ERROR => 'E_COMPILE_ERROR',
                E_COMPILE_WARNING => 'E_COMPILE_WARNING',
                E_USER_ERROR => 'E_USER_ERROR',
                E_USER_WARNING => 'E_USER_WARNING',
                E_USER_NOTICE => 'E_USER_NOTICE',
                E_STRICT => 'E_STRICT',
                E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
                E_DEPRECATED => 'E_DEPRECATED',
                E_USER_DEPRECATED => 'E_USER_DEPRECATED',
                'EXCEPTION' => 'EXCEPTION',
            );

            // Записывает ошибку в лог
            $this->writeErrorLog(
                $errors[$type],
                $message,
                $file,
                $line,
            );

            // Показывает ошибку на экран
            $this->displayError(
                $errors[$type],
                $message,
                $file,
                $line,
            );
        }
    }

    // Обрабатывает фатальную ошибку
    public function fatalErrorHandler()
    {
        // Получает информацию о последней произошедней ошибки
        $error = error_get_last();
        // Если была ошибка и она фатальна
        if (isset($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            // Очищает буфер и завершает его работу (не выводит стандартное сообщение об ошибке)
            ob_end_clean();

            // Вызывает метод для обработки ошибки
            $this->errorHandler(
                $error['type'],
                $error['message'],
                $error['file'],
                $error['line'],
            );
        } else {
            // Выводит буфер и завершает его работу
            ob_end_flush();
        }
    }
}
