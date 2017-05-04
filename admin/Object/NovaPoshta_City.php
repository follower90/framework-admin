<?php

namespace Admin\Object;

class NovaPoshta_City extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('NovaPoshta_City');
			self::$_config->setFields([
				'name_ru' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'name_ua' => [
					'type' => 'varchar',
					'default' => '',
					'null' => true,
				],
				'ref' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'last_update' => [
					'type' => 'datetime',
					'default' => null,
					'null' => true,
				],
			]);

			\Core\Orm::registerRelation(
				['type' => 'has_many', 'alias' => 'np_warhouses', 'table' => 'NovaPoshta_Warehouse'],
				['class' => 'NovaPoshta_Warehouse', 'field' => 'cityRef'],
				['class' => 'NovaPoshta_City', 'field' => 'ref']
			);
		}

		return self::$_config;
	}
}
