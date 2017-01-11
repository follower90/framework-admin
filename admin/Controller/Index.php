<?php

namespace Admin\Controller;

use Admin\Object\Module;

class Index extends Controller
{
	public function methodIndex($args)
	{
		$data['modules'] = [
			'site' => Module::where(['type' => Module::TYPE_WEBSITE])->getData(),
			'shop' => Module::where(['type' => Module::TYPE_SHOP])->getData(),
			'admin' => Module::where(['type' => Module::TYPE_ADMIN])->getData(),
			'seo' => Module::where(['type' => Module::TYPE_SEO])->getData()
		];

		$data['content'] = $this->view->render('templates/index.phtml', $data);
		return $this->render($data);
	}
}