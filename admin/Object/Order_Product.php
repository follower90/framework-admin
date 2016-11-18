<?php

namespace Admin\Object;

class Order_Product extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Order_Product');
			self::$_config->setFields([
				'languageTable' => [
					'name' => [
						'type' => 'varchar',
						'default' => '',
						'null' => false,
					]
				],
				'productId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
				'orderId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
				'price' => [
					'type' => 'float',
					'default' => 0,
					'null' => false,
				],
				'count' => [
					'type' => 'float',
					'default' => 0,
					'null' => false,
				]
			]);

			\Core\Orm::registerRelation(
				['type' => 'has_one', 'alias' => 'product', 'table' => 'Product'],
				['class' => 'Order', 'field' => 'productId'],
				['class' => 'Product', 'field' => 'id']
			);
		}

		return self::$_config;
	}
}
