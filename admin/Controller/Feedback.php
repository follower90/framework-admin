<?php

namespace Admin\Controller;

use Admin\Paging;
use Core\Orm;

class Feedback extends Controller
{
	public function methodIndex($args)
	{
		$data = [];
		$paging = Paging::create('Feedback', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['messages'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/feedback/index.phtml', $data);

		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$message = Orm::load('Feedback', $args['edit']);
		$data['message'] = $message->getValues();
		$data['content'] = $this->view->render('templates/modules/feedback/edit.phtml', $data);
		return $this->render($data);
	}

	public function methodDelete($args)
	{
		$message = Orm::load('Feedback', $args['delete']);
		Orm::delete($message);
		$this->back();
	}
}
