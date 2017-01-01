<?php

namespace Admin\Controller;

use Admin\Object\Object_Resource;
use Admin\Object\Setting;
use Core\Library\String;
use Core\View\Paging;
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
		$data['content'] = $this->view->render('templates/modules/product/add.phtml', $vars);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$product = Orm::load('Product', $args['edit']);
		$data['product'] = $product->getValues();
		$data['product']['catalog_id'] = $product->getCatalogId();
		$data['statuses'] = \Admin\Object\Product::getStatusMap();

		$data['filters'] = Orm::find('Filter')->getData();
		$data['set_filters'] = $product->getFilters()->getValues('id');

		foreach ($data['filters'] as &$filter) {
			$filter['group'] = Orm::load('FilterSet', $filter['filterSetId'])->getValue('name');
		}

		$data['edit_photo'] = $this->view->render('templates/common/image_crop.phtml', [
			'width' => Setting::get('product_image_width'),
			'height' => Setting::get('product_image_height'),
			'entity' => 'product',
			'id' => $data['product']['id'],
			'photo' => [
				1 => $product->getPhotoResourceId(Object_Resource::TYPE_PHOTO, 1),
				2 => $product->getPhotoResourceId(Object_Resource::TYPE_PHOTO, 2),
			]
		]);

		$additionalPhotos = Orm::find('Product_Resource', ['productId', 'type'], [$data['product']['id'], \Admin\Object\Product_Resource::TYPE_PHOTO_ADDITIONAL]);
		$additinalPhotosObjectResources = Orm::find('Object_Resource', ['objectId', 'objectType', 'type'], [$additionalPhotos->getValues('id'), 'product_resource', Object_Resource::TYPE_PHOTO]);

		$data['upload_more_photo'] = $this->view->render('templates/common/more_photo.phtml', [
			'width' => Setting::get('product_image_width'),
			'height' => Setting::get('product_image_height'),
			'entity' => 'product',
			'id' => $data['product']['id'],
			'photo' => $additinalPhotosObjectResources->getValues('resourceId')
		]);

		$data['catalogs'] = Orm::find('Catalog', ['active'], [1])->getHashMap('id', 'name');
		$data['content'] = $this->view->render('templates/modules/product/edit.phtml', $data);

		$this->addCssPath(['/css/cropper.min.css', '/css/dropzone.css']);
		$this->addJavaScriptPath(['/js/cropper.min.js', '/js/dropzone.js']);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		$this->checkWritePermissions();
		if (!empty($args['id'])) {
			$product = Orm::load('Product', $args['id']);
		} else {
			$product = Orm::create('Product');
		}

		if (empty($args['url'])) {
			$args['url'] = String::translit($args['name']);
		}

		$product->setValues($args);

		try {
			Orm::save($product);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$errors = explode("___", $e->getMessage());
			array_map(function($error) { $this->view->addNotice('error', $error); }, $errors);
			if ($product->isNew()) {
				Router::redirect('/admin/product/new');
			}
		}

		$product->setCatalog($args['catalog_id']);

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
		$this->checkWritePermissions();
		$product = Orm::load('Product', $args['duplicate']);
		$data = $product->getValues();
		unset($data['id']);

		$newProduct = Orm::create('Product');
		$newProduct->setValues($data);
		$newProduct->setValue('url', $product->getValue('url') .'_1');
		Orm::save($newProduct);

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
