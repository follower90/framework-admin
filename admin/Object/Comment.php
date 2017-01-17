<?php

namespace Admin\Object;

class Comment extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Comment');
			self::$_config->setFields([
				'userId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
				'date' => [
					'type' => 'datetime',
					'default' => 'CURRENT_TIMESTAMP',
					'null' => false,
				],
				'parentId' => [
					'type' => 'int',
					'default' => null,
					'null' => true,
				],
				'entity' => [
					'type' => 'varchar',
					'default' => null,
					'null' => false,
				],
				'entityId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
				'name' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'text' => [
					'type' => 'text',
					'default' => '',
					'null' => false,
				]
			]);
		}

		return self::$_config;
	}
}
