<?php

namespace Admin\Object;

class Page_View_Ip extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Page_View_Ip');
			self::$_config->setFields([
				'pageViewId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
				'ip' => [
					'type' => 'varchar',
					'default' => null,
					'null' => false,
				]
			]);
		}

		return self::$_config;
	}
}
