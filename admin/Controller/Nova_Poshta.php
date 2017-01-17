<?php

namespace Admin\Controller;

use Core\Orm;
use Core\Router;

class Nova_Poshta extends Controller
{
	public function methodIndex()
	{
		$vars['cities'] = Orm::find('NovaPoshta_City')->getCollection();
		$data['content'] = $this->view->render('templates/modules/nova_poshta/index.phtml', $vars);

		return $this->render($data);
	}

	public function methodRefresh_cities()
	{
		$cities = \App\Service\NovaPoshta::getCities();

		foreach ($cities as $item) {
			$city = Orm::findOne('NovaPoshta_City', ['ref'], [$item['Ref']]);

			if (!$city) {
				$city = Orm::create('NovaPoshta_City');
				$city->setValues([
					'name_ru' => addslashes($item['DescriptionRu']),
					'name_ua' => addslashes($item['Description']),
					'ref' => $item['Ref']
				]);

				Orm::save($city);
			}
		}

		$this->back();
	}

	public function methodRefresh_warehouses()
	{
		$cities = Orm::find('NovaPoshta_City', ['last_update'], [null])->getCollection();

		foreach ($cities as $city) {
			$warehouses = \App\Service\NovaPoshta::getWarehouses($city->getValue('ref'));

			foreach ($warehouses as $item) {
				$warehouse = Orm::findOne('NovaPoshta_Warehouse', ['ref'], [$item['Ref']]);
				if (!$warehouse) {
					$warehouse = Orm::create('NovaPoshta_Warehouse');
					$warehouse->setValues([
						'name_ru' => addslashes($item['DescriptionRu']),
						'name_ua' => addslashes($item['Description']),
						'cityRef' => $city->getValue('ref'),
						'ref' => $item['Ref']
					]);
				}
				Orm::save($warehouse);
			}

			$city->setValue('last_update', date('Y-m-d H:i:s'));
			Orm::save($city);;
		}

		$this->back();
	}
}