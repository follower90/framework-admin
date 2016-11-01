<?php

namespace Admin\Migration;

class Admin extends \Core\Database\Migration
{
	public function describe() {
		return 'Create default Admin: admin with password 1234';
	}

	public function migrate() {
		$this->_db->query("insert into Admin (login, password, name) values('admin', md5('2wegdge23t21234Uyh920ht8'), 'Admin');");
	}
}
