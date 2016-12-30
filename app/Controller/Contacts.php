<?php

namespace App\Controller;

class Contacts extends Controller
{
	public function methodIndex($args)
	{
		return $this->render([
			'content' => $this->view->render('templates/contacts.phtml'),
			'breadcrumbs' => $this->renderBreadCrumbs([['name' => __('Contacts')]])
		]);
	}
}
