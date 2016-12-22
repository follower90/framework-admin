<?php

namespace Admin\Controller;

use Core\View\Paging;
use Core\Orm;
use Core\Router;

class Mail_Template extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('MailTemplate', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['templates'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/mail_template/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$this->addCssPath(['/css/codemirror.css']);
		$this->addJavaScriptPath([
			'/js/codemirror/codemirror.js',
			'/js/codemirror/mode/htmlmixed.js',
			'/js/codemirror/mode/xml.js'
		]);

		$data['content'] = $this->view->render('templates/modules/mail_template/add.phtml', []);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$this->addCssPath(['/css/codemirror.css']);
		$this->addJavaScriptPath([
			'/js/codemirror/codemirror.js',
			'/js/codemirror/mode/htmlmixed.js',
			'/js/codemirror/mode/xml.js'
		]);

		$data['template'] = Orm::load('MailTemplate', $args['edit'])->getValues();
		$data['content'] = $this->view->render('templates/modules/mail_template/edit.phtml', $data);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		$this->checkWritePermissions();
		if (!empty($args['id'])) {
			$template = Orm::load('MailTemplate', $args['id']);
		} else {
			$template = Orm::create('MailTemplate');
		}

		$args['body'] = addslashes($args['body']);
		$template->setValues($args);

		try {
			Orm::save($template);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($template->isNew()) {
				Router::redirect('/admin/mail_template/new');
			}
		}

		Router::redirect('/admin/mail_template/edit/' . $template->getId());
	}

	public function methodDuplicate($args)
	{
		$this->checkWritePermissions();
		$page = Orm::load('MailTemplate', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$newPage = Orm::create('MailTemplate');
		$newPage->setValues($data);
		Orm::save($newPage);

		Router::redirect('/admin/mail_template/');
	}

	public function methodDelete($args)
	{
		$this->checkWritePermissions();
		$page = Orm::load('MailTemplate', $args['delete']);

		Orm::delete($page);
		$this->back();
	}
}
