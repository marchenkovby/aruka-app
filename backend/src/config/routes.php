<?php

use Aruka\Core\Router;

Router::get('', 'MainController@indexAction');
Router::get('chat', 'MainController@chatAction');
Router::get('about', 'MainController@aboutAction');
Router::get('articles/{id}', 'ArticlesController@showAction');
Router::get('articles', 'ArticlesController@indexAction');
Router::post('articles', 'ArticlesController@createAction');
Router::get('articles/{id}/edit', 'ArticlesController@editAction');
Router::get('articles/{id}/update', 'ArticlesController@updateAction');
Router::get('articles/{id}/delete', 'ArticlesController@deleteAction');

// API
// Получить статью
Router::get('api/{api_version}/articles/{id}', 'ArticlesController@apiAction');

// Получить все статьи
Router::get('api/{api_version}/articles', 'ArticlesController@apiAction');

// Создать статью
Router::post('api/v1/articles', 'ArticlesController@apiAction');

// Удалить статью
Router::delete('api/v1/articles/{id}', 'ArticlesController@apiAction');

// Заменить статью
Router::put('api/v1/articles/{id}', 'ArticlesController@apiAction');

// Обновить статью
// Router::post('api/v1/articles/{id}', 'ArticlesController@apiAction');
Router::patch('api/v1/articles/{id}', 'ArticlesController@apiAction');
