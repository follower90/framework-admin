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

			\Core\Orm::registerRelation(
				['type' => 'multiple', 'alias' => 'filter_sets', 'table' => 'Catalog__FilterSet'],
				['class' => 'Catalog'],
				['class' => 'FilterSet']
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
			$count = \Core\Orm::count('Catalog', ['url'], [$this->getValue('url')]);
			if (($this->isNew() && $count == 1) || $count > 2) {
				$this->setError('URL already exists');
			}
		}

		$errors = $this->getErrors();
		return empty($errors);
	}
}
