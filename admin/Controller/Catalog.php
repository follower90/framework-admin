<?php

namespace Admin\Controller;

use Admin\Paging;
use Core\Orm;
use Core\Router;

class Catalog extends Controller
{
	public function methodIndex($args)
	{
		$data = [];
		$parentId = $args['parent'] ? (int)$args['parent'] : 0;

		$paging = Paging::create('Catalog', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page'],
			'params' => [['parent'], [$parentId]]
		]);

		$data['paging'] = $paging->getPaging();
		$data['catalogs'] = $paging->getObjects();
		$data['all'] = Orm::find('Catalog', ['active'], [1])->getData();
		$data['current'] = $parentId;
		$data['content'] = $this->view->render('templates/modules/catalog/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$all = Orm::find('Catalog', ['active'], [1])->getData();
		$data['content'] = $this->view->render('templates/modules/catalog/add.phtml', ['all' => $all]);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$catalog = Orm::load('Catalog', $args['edit']);
		$all = Orm::find('Catalog', ['active', '!id'], [1, $args['edit']])->getData();

		$data = [
			'catalog' => $catalog->getValues(),
			'all' => $all
		];

		$data['edit_photo'] = $this->view->render('templates/common/image_crop.phtml', [
			'width' => \Admin\Object\Setting::get('catalog_image_width'),
			'height' => \Admin\Object\Setting::get('catalog_image_height'),
			'entity' => 'catalog',
			'photo' => $catalog->getPhotoResourceId(),
			'id' => $catalog->getId()
		]);

		$data['content'] = $this->view->render('templates/modules/catalog/edit.phtml', $data);

		$this->addCssPath(['/css/cropper.min.css', '/css/dropzone.css']);
		$this->addJavaScriptPath(['/js/cropper.min.js', '/js/dropzone.js']);


		return $this->render($data);
	}

	public function methodSave($args)
	{
		if (!empty($args['id'])) {
			$catalog = Orm::load('Catalog', $args['id']);
		} else {
			$catalog = Orm::create('Catalog');
		}

		if (empty($args['url'])) {
			$args['url'] = \Core\Library\String::translit($args['name']);

			if (\Core\Orm::count('Catalog', ['url'], [$args['url']])) {
				$args['url'] = $args['url'] . '_' . rand(0,1000);
			}
		}

		try {
			$catalog->updateAttributes($args);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($catalog->isNew()) {
				Router::redirect('/admin/catalog/new');
			}
		}

		Router::redirect('/admin/catalog/edit/' . $catalog->getId());
	}

	public function methodDuplicate($args)
	{
		$page = Orm::load('Catalog', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$catalog = Orm::create('Catalog');
		$catalog->updateAttributes($data);

		Router::redirect('/admin/catalog/');
	}

	public function methodDelete($args)
	{
		$page = Orm::load('Catalog', $args['delete']);

		Orm::delete($page);
		$this->back();
	}
}
