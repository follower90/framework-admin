<?php

namespace Admin\Object;

class Cart extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Cart');
			self::$_config->setFields([
				'userId' => [
					'type' => 'int',
					'default' => null,
					'null' => true,
				],
				'session' => [
					'type' => 'varchar',
					'default' => null,
					'null' => false,
				],
				'productId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
				'count' => [
					'type' => 'int',
					'default' => 1,
					'null' => false,
				]
			]);
		}

		return self::$_config;
	}

	public function getValues()
	{
		$data = parent::getValues();
		$data['product'] = \Core\Orm::load('Product', $this->getValue('productId'))->getValues();

		return $data;
	}
}
