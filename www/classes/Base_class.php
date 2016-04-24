<?


class Base{
	
	public function __consruct($db_host, $db_login, $db_pass, $db_name){
		
		$db = mysql_connect ($db_host, $db_login, $db_pass);
		mysql_select_db ($db_name, $db);
		mysql_query("SET NAMES 'utf8'");
		
		$result = mysql_query($sql);
		if(!$result) { echo 'Can`t connect to database'; die(mysql_error()); }
		
		return $result;
		
	}
	
	public function getRow($location = 'get row from db', $cols = '*', $table = 'Page', $where = " WHERE id = 1"){
		
		$query = "SELECT ".$cols." FROM ".$table.$where;
		$res = mysql_query($quey);
		
		if(!$res) { echo $location.'<br>'.$query; die(mysql_error()); } 
		
		$row = mysql_fetch_assoc($res);
		
		return $row;
		
	}
	
	public function getRows($location = 'get rows from db', $cols = '*', $table = 'Page', $where = " WHERE status = 1", $order = " ORDER BY id"){
		
		$query = "SELECT ".$cols." FROM ".$table." ".$where.$order;
		$res = mysql_query($quey);
		
		if(!$res) { echo $location.'<br>'.$query; die(mysql_error()); } 
		
		$row = mysql_fetch_assoc($res);
		
		return $row;
		
	}
	
	public function insert($location = 'isert into db', $cols = " (name) VALUES ('name')", $table = 'Page'){
		
		$query = "INSERT INTO ".$table." ".$cols;
		$res = mysql_query($quey);
		
		if(!$res) { echo $location.'<br>'.$query; die(mysql_error()); }
		
		return mysql_insert_id();
		
	}
	
	public function update($location = 'update db', $cols = "status = '1'", $table = 'Page', $where = ' WHERE status = 1'){
		
		$query = "UPDATE ".$table." SET ".$cols.$where;
		$res = mysql_query($quey);
		
		if(!$res) { echo $location.'<br>'.$query; die(mysql_error()); }
		
	}
	
	public function delete($location = 'dlete db', $cols = " (name) VALUES ('name')", $table = 'Page'){
		
		$query = "DELETE FROM ".$table.$where;
		$res = mysql_query($query);
		
		if(!$res) { echo $location.'<br>'.$query; die(mysql_error()); } 
		
	}
	
}