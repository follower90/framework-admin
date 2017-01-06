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
					'text_m' => [
						'type' => 'text',
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
				['type' => 'multiple', 'alias' => 'product_categories', 'table' => 'Product__ProductCategory'],
				['class' => 'Product'],
				['class' => 'ProductCategory']
			);

			\Core\Orm::registerRelation(
				['type' => 'multiple', 'alias' => 'filters', 'table' => 'Product__Filter'],
				['class' => 'Product'],
				['class' => 'Filter']
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
		$photos = $this->getPhotos();

		$data['photo_id'] =  isset($photos[0]) ? $photos[0]['preview'] : null;
		$data['photo_id2'] = isset($photos[1]) ? $photos[1]['preview'] : $data['photo_id'];

		$data['status_text'] = static::getStatus($this->getValue('status'));
		return $data;
	}

	public static function getStatus($id)
	{
		return static::getStatusMap()[$id];
	}

	public static function getStatusMap()
	{
		return [
			0 => __('Not available'),
			1 => __('Availabe'),
			2 => __('Pre-order'),
		];
	}

	public function setCatalog($id)
	{
		if ($id) {
			$db = PDO::getInstance();
			$db->query('delete from Product__Catalog where Product = ?', [$this->getId()]);
			$db->query('insert into Product__Catalog set Product = ?, Catalog = ?', [$this->getId(), $id]);
		}
	}

	public function setCategories($ids = [])
	{
		$db = PDO::getInstance();
		$db->query('delete from Product__ProductCategory where Product = ?', [$this->getId()]);

		foreach ($ids as $id) {
			$db->query('insert into Product__ProductCategory set Product = ?, ProductCategory = ?', [$this->getId(), $id]);
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

	public function getResourceIds($type, $num)
	{
		$resources = $this->resources();

		$photoStream = $resources->stream()->filter(function ($o) use ($num, $type) {
			return $o->getValue('type') == $type && $o->getValue('position') == $num;
		})->find();

		return new \Core\Collection($photoStream);
	}

	public function getPhotoResourceId($type, $num = 1)
	{
		$resources = $this->getResourceIds(Product_Resource::TYPE_PHOTO, $num);

		$photo = Orm::findOne('Object_Resource',
			['objectId', 'objectType', 'type'],
			[$resources->getValues('id'), 'product_resource', $type]
		);

		return $photo ? $photo->getValue('resourceId') : 0;
	}

	public function getPhotos()
	{
		$photos = Orm::find('Product_Resource', ['productId', 'type'], [$this->getId(), \Admin\Object\Product_Resource::TYPE_PHOTO], ['sort' => ['position', 'desc']]);

		$result = [];
		foreach ($photos->getCollection() as $photo) {
			$additionalPhoto = Orm::findOne('Object_Resource', ['objectId', 'objectType', 'type'], [$photo->getValue('id'), 'product_resource', Object_Resource::TYPE_PHOTO]);
			$additionalPhotoPreview = Orm::findOne('Object_Resource', ['objectId', 'objectType', 'type'], [$photo->getValue('id'), 'product_resource', Object_Resource::TYPE_PHOTO_PREVIEW]);
			$additionalPhotoOriginal = Orm::findOne('Object_Resource', ['objectId', 'objectType', 'type'], [$photo->getValue('id'), 'product_resource', Object_Resource::TYPE_PHOTO_ORIGINAL]);

			$result[] = [
				'photo' => $additionalPhoto ? $additionalPhoto->getValue('resourceId') : null,
				'original' => $additionalPhotoOriginal ? $additionalPhotoOriginal->getValue('resourceId') : null,
				'preview' => $additionalPhotoPreview ? $additionalPhotoPreview->getValue('resourceId') : null,
			];
		}

		return $result;
	}

	public function resources()
	{
		return Orm::find('Product_Resource', ['productId'], [$this->getId()]);
	}

	public function beforeDelete()
	{
		$resources = Orm::find('Product_Resource', ['productId'], [$this->getId()]);

		foreach ($resources as $productResource) {
			$productResource->remove();
		}
	}

	public function getCategoriesIds()
	{
		if (!$this->getRelated('product_categories')->isEmpty()) {
			return $this->getRelated('product_categories')->getValues('id');
		}

		return [];
	}
}
