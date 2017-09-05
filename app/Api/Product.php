<?php

namespace App\Api;

use Core\View;

class Product extends \Core\Api
{
	public function methodSearch($args)
	{
		$term = $args['search'];
		return [];
	}
}
