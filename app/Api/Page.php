<?php

namespace App\Api;

class Page extends \Core\Api
{
	public function methodIndex()
	{
		$pages = \Admin\Object\Page::all();
		return $pages->load()->getData();
	}

	public function methodGet($args)
	{
		$params = [];
		if ($args['url']) $params['url'] = $args['url'];
		if ($args['id']) $params['id'] = $args['id'];

		$page = \Admin\Object\Page::findBy($params);
		return $page ? $page->getValues() : [];
	}
}
