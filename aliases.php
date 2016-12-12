<?php

function i18n($args) {
	return \Admin\Utils::translate($args, 'app');
}

function __($args) {
	echo i18n($args);
}
