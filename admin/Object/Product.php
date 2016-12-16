<?php

namespace Admin\Object;

use Core\Database\PDO;
use Core\Orm;

class Product extends \Core\Object
{
	protected static $_config;

	const STATUS_UNAVAILABLE = 0;
	const STATUS_AVAILABLE = 1;
	const STATUS_PREORDER = 2;

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
				'status' => [
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

	public function validate()
	{
		if (trim($this->getValue('name')) === '') {
			$this->setError('Name is required');
		}

		if (trim($this->getValue('url')) === '') {
			$this->setError('URL is required');
		} else {
			$count = Orm::count('Product', ['url'], [$this->getValue('url')]);
			if (($this->isNew() && $count == 1) || $count > 2) {
				$this->setError('URL already exists');
			}
		}

		$errors = $this->getErrors();
		return empty($errors);
	}

	public function getValues()
	{
		$data = parent::getValues();
		$data['photo_id'] = $this->getPhotoResourceId();
		$data['status_text'] = $this->getStatus();

		return $data;
	}

	public function getStatus()
	{
		$statusMap = [
			0 => __('Not available'),
			1 => __('Availabe'),
			2 => __('Pre-order'),
		];

		return $statusMap[$this->getValue('status')];
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
