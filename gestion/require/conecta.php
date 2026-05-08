<?php
require_once ("configuracion.php");
class DB
{

	protected $db_name = BASE_DE_DATOS_GESTION;
	protected $db_user = USUARIO_GESTION;
	protected $db_pass = CLAVE_GESTION;
	protected $db_host = SERVER_GESTION;
	private $db;

	public function connect()
	{
		try {
			$params = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4");
			$db = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name, $this->db_user, $this->db_pass, $params);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->exec("SET NAMES utf8mb4");
			return $db;
		} catch (PDOException $e) {
			$dato = array();
			$dato['estado'] = 0;
			$dato['mensaje'] = $e->getMessage();
			$dato['class'] = 'alert-error';
			return json_encode($dato, JSON_FORCE_OBJECT);
			die();
		}
	}

	public function __call($name, array $arguments)
	{

		if (method_exists($this->db, $name)) {
			try {
				return call_user_func_array(array(&$this->db, $name), $arguments);
			} catch (Exception $e) {
				throw new Exception('Database Error: "' . $name . '" does not exists');
			}
		}
	}

	public function selectDataQuery($sql)
	{
		try {
			$conn = $this->connect();
			$recordset = $conn->query($sql);
			$row = $recordset->fetchAll(PDO::FETCH_ASSOC);
			$total = count($row);
			return ($total > 0) ? $row : array();
			$recordset->closeCursor();
		} catch (PDOExecption $e) {
			return array();
		}
	}

	public function selectAllData($table, $field, $where)
	{
		try {
			$conn = $this->connect();
			$cont_w = 1;
			$tot_where = count($where);
			$condition = '';
			if ($where != NULL) {
				foreach ($where as $key => $value) {
					($cont_w < $tot_where) ? ($sep = ' AND ') : ($sep = '');
					$condition .= "$key='$value'$sep";
					$cont_w++;
				}
			}
			$sql = "SELECT $field FROM $table";
			if (!empty($condition))
				$sql .= " WHERE $condition";
			$recordset = $conn->query($sql);
			$row = $recordset->fetchAll(PDO::FETCH_ASSOC);
			$total = count($row);
			if ($total) {
				return $row;
			} else {
				return false;
			}
			$recordset->closeCursor();
		} catch (PDOExecption $e) {
			return false;
		}
	}

	public function selectRowData($table, $field, $where)
	{
		try {
			$conn = $this->connect();
			if (!is_json($conn)) {
				$cont_w = 1;
				$tot_where = count($where);
				$condition = '';
				if ($where != NULL) {
					foreach ($where as $key => $value) {
						($cont_w < $tot_where) ? ($sep = ' AND ') : ($sep = '');
						$condition .= "$key='$value'$sep";
						$cont_w++;
					}
				}
				$sql = "SELECT $field FROM $table";
				if (!empty($condition))
					$sql .= " WHERE $condition";
				$recordset = $conn->query($sql);
				$row = $recordset->fetch(PDO::FETCH_ASSOC);
				$total = count($row);
				if ($total) {
					return $row;
				} else {
					return false;
				}
				$recordset->closeCursor();
			} else {
				echo $conn;
				die();
			}
		} catch (PDOExecption $e) {
			return false;
		}
	}

	public function insertData($table, $array)
	{
		try {
			$conn = $this->connect();
			$cont = 1;
			$rtn = false;
			$total = count($array);
			$keys = '';
			$values = '';
			foreach ($array as $key => $value) {
				($cont < $total) ? ($sep = ',') : ($sep = '');
				$keys .= "$key$sep";
				($value == NULL) ? $values .= "NULL $sep" : $values .= "'$value'$sep";
				$cont++;
			}
			$sql = "INSERT INTO $table($keys) VALUES ($values)";
			$recordset = $conn->exec($sql);
			$rtn = ($recordset) ? $conn->lastInsertId() : false;
			return $rtn;
		} catch (PDOExecption $e) {
			return $e->getMessage();
		}
	}

	public function updateData($table, $array, $where)
	{
		try {
			$conn = $this->connect();
			$cont_a = 1;
			$cont_w = 1;
			$tot_array = count($array);
			$tot_where = count($where);
			$values = '';
			$condition = '';
			foreach ($array as $key => $value) {
				($cont_a < $tot_array) ? ($sep = ',') : ($sep = '');
				($value == NULL) ? $values .= "$key=NULL $sep" : $values .= "$key='$value'$sep";
				$cont_a++;
			}
			foreach ($where as $key => $value) {
				($cont_w < $tot_where) ? ($sep = ' AND ') : ($sep = '');
				$condition .= "$key='$value'$sep";
				$cont_w++;
			}
			$values = str_replace("'NULL'", "NULL", $values);
			$sql = "UPDATE $table SET $values WHERE $condition";
			//	echo $sql; exit;
			$recordset = $conn->exec($sql);
			return ($recordset) . "<-"; // ? true : false;
		} catch (PDOExecption $e) {
			return false;
		}
	}

	public function deleteData($table, $where)
	{
		try {
			$conn = $this->connect();
			$cont_w = 1;
			$tot_where = count($where);
			$condition = '';
			foreach ($where as $key => $value) {
				($cont_w < $tot_where) ? ($sep = ' AND ') : ($sep = '');
				$condition .= "$key='$value'$sep";
				$cont_w++;
			}
			$sql = "DELETE FROM $table WHERE $condition";
			$recordset = $conn->exec($sql);
			return ($recordset) ? true : false;
			reloadPagEstadoElimina();
		} catch (PDOExecption $e) {
			return false;
		}
	}
}

?>