<?php

namespace Admin\Api;

class Admin extends \Core\Api
{
	public function methodIndex($args)
	{
		return ['success' => true];
	}
}