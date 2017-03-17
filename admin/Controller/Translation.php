<?php

namespace Admin\Controller;

use Core\Config;
use Admin\Paging;
use Core\Library\File;
use Core\Orm;
use Core\Router;

class Translation extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$filter = \Admin\Filter::init('translation');
		$filter->setFilters($args);

		$type = $filter->getFilter('type') ? $filter->getFilter('type') : 'admin';

		$paging = Paging::create('Translation', [
			'page_size' => 50,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page'],
			'params' => [['type'], [$type]]
		]);

		$data['filter'] = $filter->getFilters();
		$data['paging'] = $paging->getPaging();
		$data['translations'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/translation/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['content'] = $this->view->render('templates/modules/translation/add.phtml');
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$translation = Orm::load('Translation', $args['edit'])->getValues();
		$data['content'] = $this->view->render('templates/modules/translation/edit.phtml', ['translation' => $translation]);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		$this->checkWritePermissions();
		if (!empty($args['id'])) {
			$translation = Orm::load('Translation', $args['id']);
		} else {
			$translation = Orm::create('Translation');
		}

		try {
			$translation->updateAttributes($args);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($translation->isNew()) {
				Router::redirect('/admin/translation/new');
			}
		}

		Router::redirect('/admin/translation/edit/' . $translation->getId());
	}

	public function methodDuplicate($args)
	{
		$this->checkWritePermissions();
		$page = Orm::load('Translation', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$translation = Orm::create('Translation');
		$translation->updateAttributes($data);

		Router::redirect('/admin/translation/');
	}

	public function methodDelete($args)
	{
		$this->checkWritePermissions();
		$translation = Orm::load('Translation', $args['delete']);

		Orm::delete($translation);
		$this->back();
	}

	public function methodCache()
	{
		$types = ['admin', 'app'];
		$translationCache = File::get('/translations_cache.json');
		$data = json_decode($translationCache, true);
		$newData = [];

		foreach ($types as $type) {
			$translation = Orm::find('Translation', ['type'], [$type])->getData();
			$lang = Config::get('site.language');

			foreach ($translation as $t) {
				$newData[$lang][$type][$t['alias']] = $t['value'] ? $t['value'] : $t['alias'];
			}

			$data = array_merge($data, $newData);
		}

		File::put('/translations_cache.json', json_encode($data));
		$this->back();
	}
}
