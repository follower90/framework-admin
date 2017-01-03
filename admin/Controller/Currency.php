<?php

namespace Admin\Controller;

use Admin\Paging;
use Core\Orm;
use Core\Router;

class Currency extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('Currency', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['currencies'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/currency/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['content'] = $this->view->render('templates/modules/currency/add.phtml');
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$currency = Orm::load('Currency', $args['edit'])->getValues();
		$data['content'] = $this->view->render('templates/modules/currency/edit.phtml', ['currency' => $currency]);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		$this->checkWritePermissions();
		if (!empty($args['id'])) {
			$currency = Orm::load('Currency', $args['id']);
		} else {
			$currency = Orm::create('Currency');
		}

		$args['basic'] = isset($args['basic']) ? 1 : 0;

		if ($args['basic']) {
			Orm::find('Currency')->stream()->each(function ($object) {
					$object->setValue('basic', 0)->save();
			});
		}

		$currency->setValues($args);

		try {
			Orm::save($currency);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($currency->isNew()) {
				Router::redirect('/admin/currency/new');
			}
		}

		Router::redirect('/admin/currency/edit/' . $currency->getId());
	}

	public function methodDuplicate($args)
	{
		$this->checkWritePermissions();
		$page = Orm::load('Currency', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$newPage = Orm::create('Setting');
		$newPage->setValues($data);
		Orm::save($newPage);

		Router::redirect('/admin/currency/');
	}

	public function methodDelete($args)
	{
		$this->checkWritePermissions();
		$currency = Orm::load('Currency', $args['delete']);
		Orm::delete($currency);
		$this->back();
	}
}
