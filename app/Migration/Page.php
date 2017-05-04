<?php

namespace App\Migration;

class Page extends \Core\Database\Migration
{
	public function describe() {
		return 'Create sample page';
	}

	public function migrate() {
		$this->_db->query("insert into Page set id=1, url='my_super_url'");
		$this->_db->query("insert into Page_Lang set page_id=1, lang='ru', field='name', value ='Test Page'");
		$this->_db->query("insert into Page_Lang set page_id=1, lang='ru', field='text', value ='Text'");
	}
}
