<?php

namespace Admin\Controller;

use Admin\Object\Object_Resource;
use Admin\Object\Setting;
use Core\Library\String;
use Admin\Paging;
use Core\Orm;
use Core\Router;

class Product extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('Product', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : $args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['products'] = $paging->getObjects(true);

		$data['content'] = $this->view->render('templates/modules/product/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$vars['catalogs'] = Orm::find('Catalog', ['active'], [1])->getHashMap('id', 'name');
		$vars['statuses'] = \Admin\Object\Product::getStatusMap();

		$data['content'] = $this->view->render('templates/modules/product/add.phtml', $vars);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$product = Orm::load('Product', $args['edit']);
		$data['product'] = $product->getValues();
		$data['product']['catalog_id'] = $product->getCatalogId();
		$data['product']['categories'] = $product->getCategoriesIds();
		$data['categories'] = Orm::find('ProductCategory')->getData();
		$data['statuses'] = \Admin\Object\Product::getStatusMap();

		$data['filters'] = Orm::find('Filter')->getData();
		$data['set_filters'] = $product->getFilters()->getValues('id');

		foreach ($data['filters'] as &$filter) {
			$filter['group'] = Orm::load('FilterSet', $filter['filterSetId'])->getValue('name');
		}

		$photosArray = [];
		$photos = Orm::find('Product_Resource', ['productId', 'type'], [$data['product']['id'], \Admin\Object\Product_Resource::TYPE_PHOTO], ['sort' => ['position', 'desc']]);

		foreach ($photos->getCollection() as $p) {
			$photosObjectResource = Orm::findOne('Object_Resource', ['objectId', 'objectType', 'type'], [$p->getValue('id'), 'product_resource', Object_Resource::TYPE_PHOTO]);
			$photosArray[$p->getValue('id')] = $photosObjectResource->getValue('resourceId');
		}

		$data['photo'] = $this->view->render('templates/modules/product/more_photo.phtml', [
			'width' => Setting::get('product_image_width'),
			'height' => Setting::get('product_image_height'),
			'width_preview' => Setting::get('product_image_preview_width'),
			'height_preview' => Setting::get('product_image_preview_height'),
			'id' => $data['product']['id'],
			'photo' => $photosArray
		]);

		$data['catalogs'] = Orm::find('Catalog', ['active'], [1])->getHashMap('id', 'name');
		$data['content'] = $this->view->render('templates/modules/product/edit.phtml', $data);

		$this->addCssPath(['/css/cropper.min.css']);
		$this->addJavaScriptPath(['/js/cropper.min.js']);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		if (!empty($args['id'])) {
			$product = Orm::load('Product', $args['id']);
		} else {
			$product = Orm::create('Product');
		}

		if (empty($args['url'])) {
			$args['url'] = String::translit($args['name']);
		}

		try {
			$product->updateAttributes($args);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$errors = explode("___", $e->getMessage());
			array_map(function($error) { $this->view->addNotice('error', $error); }, $errors);
			if ($product->isNew()) {
				Router::redirect('/admin/product/new');
			}
		}

		$product->setCatalog($args['catalog_id']);
		$product->setCategories($args['categories']);

		Router::redirect('/admin/product/edit/' . $product->getId());
	}

	public function methodSavefilters($args)
	{
		$product = Orm::load('Product', $args['id']);

		$product->setFilters($args['filterId']);
		Router::redirect('/admin/product/edit/' . $product->getId());
	}

	public function methodDuplicate($args)
	{
		$product = Orm::load('Product', $args['duplicate']);
		$data = $product->getValues();
		unset($data['id']);
		$data['url'] = $product->getValue('url') .'_1';

		$newProduct = Orm::create('Product');
		$newProduct->updateAttributes($data);

		$newProduct->setCatalog($product->getCatalogId());
		$newProduct->setFilters($product->getFilters()->getValues('id'));

		Router::redirect('/admin/product/');
	}

	public function methodDelete($args)
	{
		$product = Orm::load('Product', $args['delete']);
		Orm::delete($product);
		$this->back();
	}
}
