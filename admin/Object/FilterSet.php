<?php

namespace Admin\Object;

class FilterSet extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('FilterSet');
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
				'alias' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
			]);

			\Core\Orm::registerRelation(
				['type' => 'has_many', 'alias' => 'filters', 'table' => 'Filter'],
				['class' => 'Filter', 'field' => 'filterSetId'],
				['class' => 'FilterSet', 'field' => 'id']
			);
		}

		return self::$_config;
	}
}
