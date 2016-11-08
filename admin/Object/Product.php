<?php

namespace Admin\Object;

use Core\Database\PDO;

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
				'active' => [
					'type' => 'tinyint',
					'default' => 1,
					'null' => false,
				],
			]);
		}

		\Core\Orm::registerRelation(
			['type' => 'multiple', 'alias' => 'catalog', 'table' => 'Product__Catalog'],
			['class' => 'Product'],
			['class' => 'Catalog']
		);

		return self::$_config;
	}

	public function setCatalog($id)
	{
		if ($id) {
			$db = PDO::getInstance();
			$db->query('delete from Product__Catalog where Product = ?', [$this->getId()]);
			$db->query('insert into Product__Catalog set Product = ?, Catalog = ?', [$this->getId(), $id]);
		}
	}

	public function getCatalogId()
	{
		if (!$this->getRelated('catalog')->isEmpty()) {
			return $this->getRelated('catalog')->getFirst()->getId();
		}

		return null;
	}
}
