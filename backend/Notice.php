<?php

namespace Admin;

class Notice extends \Core\Notice
{
	function show()
	{
		return '<div class="alert alert-' . $this->_type . '">' . $this->_text . '</div>';
	}
}
