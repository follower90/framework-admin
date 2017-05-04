<?php

namespace App\Api;

class NovaPoshta extends \Core\Api
{
	public function methodCities()
	{
		return [
			'items' => \Core\Orm::find('NovaPoshta_City')->getData()
		];
	}

	public function methodWarehouses($args)
	{
		return [
			'items' => \Core\Orm::find('NovaPoshta_Warehouse', ['cityRef'], [$args['cityRef']])->getData()
		];
	}
}
