<?php

namespace Admin\Object;

class Catalog extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Catalog');
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
				'parent' => [
					'type' => 'int',
					'default' => null,
					'null' => true,
				],
				'active' => [
					'type' => 'tinyint',
					'default' => 1,
					'null' => false,
				],
			]);

			\Core\Orm::registerRelation(
				['type' => 'multiple', 'alias' => 'products', 'table' => 'Product__Catalog'],
				['class' => 'Catalog'],
				['class' => 'Product']
			);
		}

		return self::$_config;
	}

	public function getValuesWithPhoto()
	{
		$data = parent::getValues();
		$data['photo_id'] = $this->getPhotoResourceId();

		return $data;
	}

	public function validate()
	{
		if (trim($this->getValue('name')) === '') {
			$this->setError('Name is required');
		}

		if (trim($this->getValue('url')) === '') {
			$this->setError('URL is required');
		} else {
			$count = \Core\Orm::count('Catalog', ['url'], [$this->getValue('url')]);
			if (($this->isNew() && $count == 1) || $count > 2) {
				$this->setError('URL already exists');
			}
		}

		$errors = $this->getErrors();
		return count($errors) === 0;
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
		return \Core\Orm::find('Object_Resource', ['objectType', 'objectId'], ['catalog', $this->getId()]);
	}
}
