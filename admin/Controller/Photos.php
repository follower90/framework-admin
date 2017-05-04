<?php

namespace Admin\Controller;

use Admin\Paging;
use Core\Orm;
use Core\Router;

class Photos extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('Photo_Album', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : $args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['albums'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/photos/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['content'] = $this->view->render('templates/modules/photos/add.phtml', $vars);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$product = Orm::load('Photo_Album', $args['edit']);
		$data['album'] = $product->getValues();

		$data['content'] = $this->view->render('templates/modules/photos/edit.phtml', $data);

		$this->addCssPath(['/css/dropzone.css']);
		$this->addJavaScriptPath(['/js/dropzone.js']);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		if (!empty($args['id'])) {
			$album = Orm::load('Photo_Album', $args['id']);
		} else {
			$album = Orm::create('Photo_Album');
		}

		try {
			$album->updateAttributes($args);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($album->isNew()) {
				Router::redirect('/admin/photos/new');
			}
		}

		Router::redirect('/admin/photos/edit/' . $album->getId());
	}

	public function methodSavefilters($args)
	{
		$product = Orm::load('Photo_Album', $args['id']);

		$product->setFilters($args['filterId']);
		Router::redirect('/admin/photos/edit/' . $product->getId());
	}

	public function methodDuplicate($args)
	{
		$product = Orm::load('Photo_Album', $args['duplicate']);
		$data = $product->getValues();
		unset($data['id']);

		$album = Orm::create('Photo_Album');
		$album->updateAttributes($data);

		Router::redirect('/admin/photos/');
	}

	public function methodDelete($args)
	{
		$page = Orm::load('Photo_Album', $args['delete']);

		Orm::delete($page);
		$this->back();
	}
}
