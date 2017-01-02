<?php

namespace App\Controller;


class Contacts extends Controller
{
	public function methodIndex($args)
	{
		if (isset($args['send'])) {

			if (!empty($args['name']) && !empty($args['email']) && !empty($args['message'])) {
				$message = new \Admin\Object\Feedback([
					'name' => $args['name'],
					'email' => $args['email'],
					'subject' => $args['subject'],
					'body' => $args['message']
				]);

				$message->save();

				$this->view->addNotice('success', __('Message sent'));
			} else {

				$this->view->addNotice('error', __('Please fill the form'));
			}
		}

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
