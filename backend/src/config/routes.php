<?php

use Aruka\Core\Router;

Router::addRoute('GET', '', 'MainController@indexAction');
Router::addRoute('GET', 'error', 'ErrorController@index');

Router::addRoute('GET', 'articles', 'ArticlesController@indexAction');
Router::addRoute('GET', 'articles/{id}', 'ArticlesController@showAction');

Router::addRoute('POST', 'articles/{id}/edit', 'ArticlesController@editAction');
Router::addRoute('PUT', 'articles/{id}/update', 'ArticlesController@updateAction');
Router::addRoute('DELETE', 'articles/{id}/delete', 'ArticlesController@deleteAction');

Router::addRoute('GET', 'about', 'AboutController@indexAction');
Router::addRoute('GET', 'chat', 'ChatController@indexAction');

Router::addRoute('GET', 'api/v1/articles', 'api\v1\ArticlesController@indexAction');
Router::addRoute('GET', 'api/v1/articles/{id}', 'api\v1\ArticlesController@showAction');
