<?php
require 'core/bootstrap.php';

$routes = [
	'/' => 'SalesController@overview',
	'/overview' => 'SalesController@overview',
	'/notpayed' => 'SalesController@overview',
	'/edit' => 'SalesController@edit',
	'/delete' => 'SalesController@delete',
	'/new' => 'SalesController@newTicket',
	'/validatenew' => 'SalesController@validatenew',
	'/validateedit' => 'SalesController@validateedit',
];

$db = [
	'name'     => 'ticketsales',
	'username' => 'root',
	'password' => '',
];

$router = new Router($routes);
$router->run($_GET['url'] ?? '');