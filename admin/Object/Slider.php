<?php

namespace Admin\Object;

use Core\Orm;

class Slider extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Slider');
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
					'default' => 1,
					'null' => false,
				],
			]);
		}

		return self::$_config;
	}

	public function getValues()
	{
		$data = parent::getValues();
		$data['photo_id'] = $this->getPhotoResourceId();

		return $data;
	}

	public function getPhotoResourceId()
	{
		$resources = $this->resources();
		$photo = $resources->stream()->filter(function ($o) {
			return $o->getValue('type') == Object_Resource::TYPE_PHOTO;
		})->findFirst();

		return $photo ? $photo->getValue('resourceId') : 0;
	}

	public function resources()
	{
		return Orm::find('Object_Resource', ['objectType', 'objectId'], ['slider', $this->getId()]);
	}
}
