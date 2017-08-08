<?php

namespace Admin\Controller;

use Admin\Object\Setting;
use Admin\Paging;
use Core\Orm;
use Core\Router;

class Slider extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('Slider', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : $args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['slides'] = $paging->getObjects(true);

		$data['content'] = $this->view->render('templates/modules/slider/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['content'] = $this->view->render('templates/modules/slider/add.phtml');
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$slide = Orm::load('Slider', $args['edit']);
		$data['slide'] = $slide->getValues();

		$data['edit_photo'] = $this->view->render('templates/common/image_crop.phtml', [
			'width' => Setting::get('slider_image_width'),
			'height' => Setting::get('slider_image_height'),
			'entity' => 'slider',
			'photo' => $slide->getPhotoResourceId(),
			'id' => $data['slide']['id']
		]);

		$data['content'] = $this->view->render('templates/modules/slider/edit.phtml', $data);

		$this->addCssPath(['/css/cropper.min.css']);
		$this->addJavaScriptPath(['/js/cropper.min.js']);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		if (!empty($args['id'])) {
			$slide = Orm::load('Slider', $args['id']);
		} else {
			$slide = Orm::create('Slider');
		}

		try {
			$slide->updateAttributes($args);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$errors = explode('___', $e->getMessage());
			array_map(function($error) { $this->view->addNotice('error', $error); }, $errors);
			if ($slide->isNew()) {
				Router::redirect('/admin/slider/new');
			}
		}

		Router::redirect('/admin/slider/edit/' . $slide->getId());
	}

	public function methodSavefilters($args)
	{
		$product = Orm::load('Slider', $args['id']);

		$product->setFilters($args['filterId']);
		Router::redirect('/admin/slider/edit/' . $product->getId());
	}

	public function methodDuplicate($args)
	{
		$slider = Orm::load('Slider', $args['duplicate']);
		$data = $slider->getValues();
		unset($data['id']);
		$data['url'] = $slider->getValue('url') .'_1';

		$newSlider = Orm::create('Slider');
		$newSlider->updateAttributes($data);

		Router::redirect('/admin/slider/');
	}

	public function methodDelete($args)
	{
		$page = Orm::load('Slider', $args['delete']);

		Orm::delete($page);
		$this->back();
	}
}
