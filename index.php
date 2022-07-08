<?php
require 'core/bootstrap.php';

$routes = [
	'/' => 'SalesController@overview',
	'/overview' => 'SalesController@overview',
	'/notpayed' => 'SalesController@notpayed',
	'/edit' => 'SalesController@edit',
	'/delete' => 'SalesController@delete',
	'/new' => 'SalesController@newTicket',
	'/validatenew' => 'SalesController@validatenew',
	'/validateedit' => 'SalesController@validateedit',
];

$db = [
	'name'     => 'kurseictbz_30711',
	'username' => 'kurseictbz_30711',
	'password' => 'db_307_pw_11',
];

$router = new Router($routes);
$router->run($_GET['url'] ?? '');