<?php

namespace Admin\Controller;

class Database extends Controller
{
	public function methodIndex($args)
	{
		$data['connection'] = \Core\Config::dbConnection();
		$data['content'] = $this->view->render('templates/modules/database/index.phtml', $data);
		return $this->render($data);
	}

	public function methodExport()
	{
		$filename = 'db-export_' . date('Y-m-d H:i:s') . '.sql';
		\Core\Library\File::save('tmp/' . $filename, $this->backup_tables());
		\Core\Library\File::upload('tmp/' . $filename);
	}

	function backup_tables()
	{
		$return = '';
		$tables = $this->db->rows('SHOW TABLES');
		foreach ($tables as $key => $table) {
			$table = reset($table);

			$result = $this->db->rows('SELECT * FROM ' . $table);
			$num_fields = $this->db->cell("SELECT count(*) FROM information_schema.columns WHERE table_schema=? and table_name = ?", [\Core\Config::dbConnection()['name'], $table]);

			$return .= 'DROP TABLE ' . $table . ';';
			$row2 = $this->db->row('SHOW CREATE TABLE ' . $table);
			$return .= "\n\n" . $row2['Create Table'] . ";\n\n";

			for ($i = 0; $i < $num_fields; $i++) {

				foreach ($result as $row) {
					$return .= 'INSERT INTO ' . $table . ' VALUES';
					foreach ($row as &$val) {
						$val = addslashes($val);
						$val = ereg_replace("\n", "\\n", $val);
						if (isset($val)) {
							$val = '"' . $val . '"';
						} else {
							$val = '""';
						}
					}
					$return .= "("  . implode(',', $row) . ");\n";
				}
			}
			$return .= "\n\n";
		}

		return $return;
	}
}