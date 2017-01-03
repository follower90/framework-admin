<?php

namespace Admin\Object;

class ProductCategory extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('ProductCategory');
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
				]
			]);

			\Core\Orm::registerRelation(
				['type' => 'multiple', 'alias' => 'category_products', 'table' => 'Product__ProductCategory'],
				['class' => 'ProductCategory'],
				['class' => 'Product']
			);
		}

		return self::$_config;
	}
}
