<?php

namespace App;

class Notice extends \Core\View\Notice
{
	private $_typesMap = [
		'error' => 'danger',
		'success' => 'success',
	];

	public function show()
	{
		return '<div class="alert alert-' . $this->_typesMap[$this->_type] . '">' . $this->_text . '</div>';
	}
}
