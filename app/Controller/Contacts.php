<?php

namespace App\Controller;


use Admin\Object\InfoBlock;

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
			'address' => InfoBlock::getText('contacts__address'),
			'phone' => InfoBlock::getText('contacts__phone'),
			'email' => InfoBlock::getText('contacts__email'),
			'values' => $args
		];

		return $this->render([
			'content' => $this->view->render('templates/contacts.phtml', $data),
			'breadcrumbs' => $this->renderBreadCrumbs([['name' => __('Contacts')]])
		]);
	}
}
