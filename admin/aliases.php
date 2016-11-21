<?php

function i18n($args) {
	return \Admin\Utils::translate($args, 'admin');
}

function __($args) {
	echo i18n($args);
}

function _snippet($name, $params) {
	return call_user_func_array(['\Admin\Snippet', $name ], $params);
}
