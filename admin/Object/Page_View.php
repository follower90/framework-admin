<?php

namespace Admin\Object;

class Page_View extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Page_View');
			self::$_config->setFields([
				'type' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'pageId' => [
					'type' => 'int',
					'default' => null,
					'null' => true,
				],
				'count' => [
					'type' => 'int',
					'default' => 1,
					'null' => false,
				],
			]);
		}

		return self::$_config;
	}
}
