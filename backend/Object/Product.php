<?php

namespace Admin\Object;

class Product extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Page');
			self::$_config->setFields([
				'languageTable' => [
					'name' => [
						'type' => 'varchar',
						'default' => '',
						'null' => false,
					],
					'text' => [
						'type' => 'text',
						'default' => '',
						'null' => false,
					],
				],
				'url' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'active' => [
					'type' => 'tinyint',
					'default' => 0,
					'null' => false,
				],
			]);
		}

		\Core\Orm::registerRelation(
			['type' => 'multiple', 'alias' => 'catalog', 'table' => 'Product__Catalog'],
			['class' => 'Product'],
			['class' => 'Catalog']
		);

		return self::$_config;
	}
}
