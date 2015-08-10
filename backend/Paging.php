<?php

namespace Admin;

use \Core\View;

class Paging
{
	private $_class;
	private $_curPage;
	private $_onPage;

	private $_paging = [];
	private $_data = [];

	private function __construct($className, $currentPage, $onPage)
	{
		$this->_class = $className;
		$this->_curPage = $currentPage;
		$this->_onPage = $onPage;
	}

	public static function create($className, $params = [])
	{
		$paging = new static($className, $params['current_page'], $params['page_size']);
		$paging->_calculate();

		return $paging;
	}

	private function _calculate()
	{
		$this->_paging['offset'] = ($this->_curPage - 1) * $this->_onPage;
		$this->_paging['limit'] = $this->_onPage;
		$this->_paging['page'] = $this->_curPage;
		$this->_paging['onpage'] = $this->_onPage;

		$this->_data = \Core\Orm::find($this->_class, [], [], $this->_paging)->getData();

		$this->_paging['total'] = \Core\Orm::count($this->_class, [], []);
		$this->_paging['items'] = count($this->_data);
	}

	public function getPaging()
	{
		$view = new View();
		$view->setDefaultPath('/vendor/follower/admin/public');

		return $view->render('templates/common/paging.phtml', $this->_paging);
	}

	public function getObjects()
	{
		return $this->_data;
	}
}
