<?php

namespace Admin\Service;

use Core\Orm;

class Admin_Group_Permission
{
	public static function updatePermissions($groupId, $modulePermissionsMap)
	{
		$permissions = Orm::find('Admin_Group_Permission', ['groupId'], [$groupId]);

		foreach ($permissions->getCollection() as $p) {
			Orm::delete($p);
		}

		foreach ($modulePermissionsMap as $moduleId => $permission) {
			$p = Orm::create('Admin_Group_Permission');
			$p->setValues([
				'moduleId' => $moduleId,
				'groupId' => $groupId,
				'permission' => $permission
			]);

			Orm::save($p);
		}
	}
}
