<?php

namespace Admin\Service;

use Core\App;
use Core\Collection;
use Core\Orm;
use Core\Router;

class Module
{
	public static function getAvailableModules()
	{
		$modules = Orm::find('Module')->getCollection();
		$admin = App::get()->getUser();
		$available = [];

		$permissions = Orm::find('Admin_Group_Permission', ['groupId'], [$admin->getValue('groupId')])
			->getHashMap('moduleId', 'permission');

		foreach ($modules as $module) {
			if (isset($permissions[$module->getId()]) && $permissions[$module->getId()] > 0) {
				array_push($available, $module);
			}
		}

		return new Collection($available);
	}

	public static function detect()
	{
		$uri = Router::get('uri');
		$moduleUri = explode('/', $uri)[2];

		return Orm::findOne('Module', ['url'], [$moduleUri]);
	}

	public static function isAvailableFor($permissionTypeId)
	{
		$admin = App::get()->getUser();
		if (!static::detect()) {
			return true;
		}

		$permission = Orm::findOne('Admin_Group_Permission', ['moduleId', 'groupId'], [static::detect()->getId(), $admin->getValue('groupId')]);
		return $permission->getValue('permission') >= $permissionTypeId;
	}
}
