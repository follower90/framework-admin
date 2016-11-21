<?php

namespace Admin\Object;

class Filter extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Filter');
			self::$_config->setFields([
				'languageTable' => [
					'name' => [
						'type' => 'varchar',
						'default' => '',
						'null' => false,
					],
					'info' => [
						'type' => 'text',
						'default' => '',
						'null' => false,
					],
				],
				'filterSetId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
			]);

			\Core\Orm::registerRelation(
				['type' => 'has_one', 'alias' => 'filter_set', 'table' => 'FilterSet'],
				['class' => 'Filter', 'field' => 'filterSetId'],
				['class' => 'FilterSet', 'field' => 'id']
			);
		}

		return self::$_config;
	}
}
