<?php

// Выводит различные массивы и другие переменные в удобном виде
function debug($var): void
{
    echo '<pre>', print_r($var, true), '</pre>', '<hr>';
}

// Перенаправляет на определенный URL
function redirect(string $url): void
{
    header('location: ' . $url);
    exit;
}
