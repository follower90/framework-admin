<?php

namespace Admin\Controller;

class Index extends Controller
{
	public function methodIndex($args)
	{
		$data['content'] = $this->view->render('templates/index.phtml', $args);

		$this->addCssPath([
			'/bower_components/morrisjs/morris.css',
			'/dist/css/timeline.css',
		]);

		$this->addJavaScriptPath([
			'/bower_components/raphael/raphael-min.js',
			'/bower_components/morrisjs/morris.min.js',
			'/js/morris-data.js',
		]);

		return $this->render($data);
	}
}