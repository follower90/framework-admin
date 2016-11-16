<?php

namespace Admin\Controller;

class Database extends Controller
{
	public function methodIndex()
	{
		$data['content'] = $this->view->render('templates/modules/database/index.phtml');
		return $this->render($data);
	}

	public function methodExport()
	{
		$filename = 'db-export_' . date('Y-m-d H:i') . '.sql';
		\Core\Library\File::put('/tmp/' . $filename, $this->export());
		\Core\Library\File::upload(\Core\App::get()->getAppPath() . '/tmp/' . $filename);
	}

	private function export()
	{
		$result = '';
		$tables = $this->db->rows('SHOW TABLES');
		foreach ($tables as $table) {
			$table = reset($table);
			$data = $this->db->rows('SELECT * FROM ' . $table);
			$create = $this->db->row('SHOW CREATE TABLE ' . $table);
			$result .= "\n\n" . $create['Create Table'] . ";\n\n";

			foreach ($data as $row) {
				$result .= 'INSERT INTO ' . $table . ' VALUES';
				foreach ($row as &$val) {
					$val = addslashes($val);
					$val = ereg_replace("\n", "\\n", $val);
					if (isset($val)) {
						if (!is_numeric($val)) $val = '"' . $val . '"';
					} else {
						$val = '""';
					}
				}
				$result .= "(" . implode(',', $row) . ");\n";
			}

			$result .= "\n\n";
		}

		return $result;
	}
}
