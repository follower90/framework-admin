<?php

namespace Admin\Object;

use Core\Database\PDO;
use Core\Orm;

class Product extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Product');
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
				'price' => [
					'type' => 'float',
					'default' => 0,
					'null' => false,
				],
				'active' => [
					'type' => 'tinyint',
					'default' => 1,
					'null' => false,
				],
			]);

			\Core\Orm::registerRelation(
				['type' => 'multiple', 'alias' => 'catalog', 'table' => 'Product__Catalog'],
				['class' => 'Product'],
				['class' => 'Catalog']
			);

			\Core\Orm::registerRelation(
				['type' => 'multiple', 'alias' => 'filters', 'table' => 'Product__Filter'],
				['class' => 'Product'],
				['class' => 'Filter']
			);

			\Core\Orm::registerRelation(
				['type' => 'has_many', 'alias' => 'resources', 'table' => 'Product_Resource'],
				['class' => 'Product', 'field' => 'id'],
				['class' => 'Product_Resource', 'field' => 'productId']
			);
		}

		return self::$_config;
	}


	public function getValues()
	{
		$data = parent::getValues();
		$data['photo_id'] = $this->getPhotoResourceId();

		return $data;
	}

	public function setCatalog($id)
	{
		if ($id) {
			$db = PDO::getInstance();
			$db->query('delete from Product__Catalog where Product = ?', [$this->getId()]);
			$db->query('insert into Product__Catalog set Product = ?, Catalog = ?', [$this->getId(), $id]);
		}
	}

	public function setFilters($ids = [])
	{
		$db = PDO::getInstance();
		$db->query('delete from Product__Filter where Product = ?', [$this->getId()]);


		foreach ($ids as $filter) {
			$db->query('insert into Product__Filter set Product = ?, Filter = ?', [$this->getId(), $filter]);
		}
	}

	public function getFilters()
	{
		return $this->getRelated('filters');
	}

	public function getCatalogId()
	{
		if (!$this->getRelated('catalog')->isEmpty()) {
			return $this->getRelated('catalog')->getFirst()->getId();
		}

		return null;
	}

	public function getResourceIds($type)
	{
		$resources = $this->getRelated('resources');
		$photo = $resources->stream()->filter(function ($o) use ($type) {
			return $o->getValue('type') == $type;
		})->findFirst();

		return $photo->getValues('resourceId');
	}

	public function getPhotoResourceId()
	{
		$resources = $this->getRelated('resources');
		$photo = $resources->stream()->filter(function ($o) {
			return $o->getValue('type') == Product_Resource::TYPE_PHOTO;
		})->findFirst();

		return $photo ? $photo->getValue('resourceId') : 0;
	}
}
