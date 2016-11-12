<?php

function __($args) {
	echo \Admin\Utils::translate($args, 'admin');
}

function _snippet($name, $params) {
	return call_user_func_array(['\Admin\Snippet', $name ], $params);
}