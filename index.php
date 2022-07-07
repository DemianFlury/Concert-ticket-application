<?php
require 'core/bootstrap.php';

$routes = [
	'/overview' => 'SalesController@overview',
	'/edit' => 'SalesController@edit',
	'/new' => 'SalesController@newTicket',
];

$db = [
	'name'     => 'meinedatenbank',
	'username' => 'root',
	'password' => '',
];

$router = new Router($routes);
$router->run($_GET['url'] ?? '');