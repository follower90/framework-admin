<?php

\Core\Config::setDb('default', [
	'host' => '127.0.0.1',
	'name' =>  'admin',
	'user' => 'root',
	'password' => '',
	'charset' => 'utf8'
]);

\Core\Config::registerProject('Admin', 'default');
