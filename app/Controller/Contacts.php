<?php

namespace App\Controller;

class Contacts extends Controller
{
	public function methodIndex($args)
	{
//		if ($args['send']) {
//			\App\Service\Mail::send('emai', 'subject', 'body');
//		}

		$data = [
			'address' => \Core\Orm::findOne('InfoBlock', ['alias'], ['contacts__address'])->getValue('text'),
			'phone' => \Core\Orm::findOne('InfoBlock', ['alias'], ['contacts__phone'])->getValue('text'),
			'email' => \Core\Orm::findOne('InfoBlock', ['alias'], ['contacts__email'])->getValue('text'),
		];

		return $this->render([
			'content' => $this->view->render('templates/contacts.phtml', $data),
			'breadcrumbs' => $this->renderBreadCrumbs([['name' => __('Contacts')]])
		]);
	}
}
