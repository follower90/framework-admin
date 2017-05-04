<?php

namespace Admin\Api;

class Admin extends \Core\Api
{
	public function methodActive($args)
	{
		if (!$args['id']) return false;
		$admin = \Admin\Object\Admin::find($args['id']);
		$admin->setValue('active', (int)$args['active']);
		$admin->save();

		return ['success' => true];
	}

	public function methodLogin()
	{
		return ['success' => true];
	}
}
