<?php

namespace App\Service;

use Core\Orm;
use Core\Router;

class Page_View
{
	public static function view($id, $type)
	{
		$pageView = Orm::findOne('Page_View', ['pageId', 'type'], [$id, $type]);
		$ip = Router::get('remote_addr');

		if ($pageView) {
			$pageViewIp = Orm::findOne('Page_View_Ip', ['pageViewId', 'ip'], [$pageView->getId(), $ip]);
			if (!$pageViewIp) {
				$pageViewIp = Orm::create('Page_View_Ip');
				$pageViewIp->setValues([
					'pageViewId' => $pageView->getId(),
					'ip' => $ip
				]);

				$pageViewIp->save();

				$pageView->setValue('count', $pageView->getValue('count') + 1);
				$pageView->save();
			}
		} else {
			$pageView = Orm::create('Page_View');
			$pageView->setValues([
				'pageId' => $id,
				'type' => $type
			]);

			$pageView->save();

			$pageViewIp = Orm::create('Page_View_Ip');
			$pageViewIp->setValues([
				'pageViewId' => $pageView->getId(),
				'ip' => $ip
			]);

			$pageViewIp->save();
		}
	}

	public static function get($id, $type)
	{
		return Orm::count('Page_View', ['pageId', 'type'], [$id, $type]);
	}
}
