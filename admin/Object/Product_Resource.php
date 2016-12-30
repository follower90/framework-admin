<?php

namespace Admin\Object;

class Product_Resource extends \Core\Object
{
	const TYPE_PHOTO = 1;
	const TYPE_PHOTO_ADDITIONAL = 2;

	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Product_Resource');
			self::$_config->setFields([
				'productId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
				'type' => [
					'type' => 'tinyint',
					'default' => null,
					'null' => false,
				],
				'position' => [
					'type' => 'tinyint',
					'default' => null,
					'null' => false,
				],
			]);
		}

		return self::$_config;
	}

	public function resources()
	{
		return \Core\Orm::find('Object_Resource', ['objectType', 'objectId'], ['product_resource', $this->getId()]);
	}

	public function remove()
	{
		$objectResources = $this->resources();
		foreach ($objectResources as $resource) {
			$resource->remove();
		}
	}
}