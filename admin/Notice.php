<?php

namespace Admin;

class Notice extends \Core\View\Notice
{
	private $_typesMap = [
		'error' => 'danger',
	];

	function show()
	{
		return '<div class="alert alert-' . $this->_typesMap[$this->_type] . '">' . $this->_text . '</div>';
	}
}
