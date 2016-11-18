<?php

namespace Admin\Object;

class Order extends \Core\Object
{
	protected static $_config;

	const STATUS_NEW = 1;
	const STATUS_PROCESS = 2;
	const STATUS_FINISHED = 3;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Order');
			self::$_config->setFields([
				'languageTable' => [
					'name' => [
						'type' => 'varchar',
						'default' => '',
						'null' => false,
					]
				],
				'userId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
				'sum' => [
					'type' => 'float',
					'default' => 0,
					'null' => false,
				],
				'status' => [
					'type' => 'tinyint',
					'default' => 1,
					'null' => false,
				],
			]);
		}

		\Core\Orm::registerRelation(
			['type' => 'has_many', 'alias' => 'products', 'table' => 'Order_Product'],
			['class' => 'Order', 'field' => 'id'],
			['class' => 'Order_Product', 'field' => 'orderId']
		);

		return self::$_config;
	}
}
