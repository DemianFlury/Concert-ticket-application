<?php
require 'core/bootstrap.php';

$routes = [
	'/' => 'SalesController@overview',
	'/overview' => 'SalesController@overview',
	'/edit' => 'SalesController@edit',
	'/new' => 'SalesController@newTicket',
	'/validate' => 'SalesController@validate',
];

$db = [
	'name'     => 'ticketsales',
	'username' => 'root',
	'password' => '',
];

$router = new Router($routes);
$router->run($_GET['url'] ?? '');