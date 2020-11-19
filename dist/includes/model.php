<?php
	require_once('database.php');
	require_once('functions.php');

	class Model{
		protected function attributes(){
			$attributes = array();

			foreach (static::$db_fields as $field) {
				if(property_exists($this, $field)){
					$attributes[$field] = $this->$field;
				}
			}

			return $attributes;
		}

		private static function get_table(){
			return $table_name = static::$table_name;
		}

		protected function sanitized_attributes() {
		  global $database;
		  $clean_attributes = array();
		  // sanitize the values before submitting
		  // Note: does not alter the actual value of each attribute
		  foreach($this->attributes() as $key => $value){
		    $clean_attributes[$key] = $database->escape_value($value);
		  }
		  return $clean_attributes;
		}

		public static function all() {
			global $database;
			$result_set = static::process_rows($database->all(static::get_table()));

			return !empty($result_set) ? $result_set : [];
		}

		public static function find($id=0) {
			global $database;
			$result_set = static::process_rows($database->find(static::get_table(), $id));

			return !empty($result_set) ? array_shift($result_set) : false;
		}

		public static function find_or_save($object_array, $field) {
			global $database;
			$table_name = static::get_table();
			$query_sql = "SELECT id FROM $table_name WHERE $field = '$object_array[$field]'";
			$result_set = static::process_rows($database->query($query_sql));
			$value = static::from_array($object_array);

			if(empty($result_set)){
				$newid = $value->create();
				
				echo "Added it! <br>";
				return static::find($newid);
			}else{
				echo "Found it! <br>";
				return static::get($field, $object_array[$field]);;
			}
		}

		public static function findWhere($condition) {
			global $database;
			$result_set = static::process_rows($database->find_where(static::get_table(), $condition));

			return !empty($result_set) ? $result_set : [];
		}

		public static function get($field, $value) {
			global $database;
			$table_name = static::get_table();
			$query_sql = "SELECT * FROM $table_name WHERE $field = '$value'";
			$result_set = static::process_rows($database->query($query_sql));

			return !empty($result_set) ? $result_set : [];
		}

		public static function get_where($condition) {
			global $database;
			$result_set = static::process_rows($database->find_where(static::get_table(), $condition));

			return !empty($result_set) ? $result_set : [];
		}

		public static function exists($condition) {
			global $database;

			$table_name = static::get_table();
			$query_sql = "SELECT * FROM $table_name WHERE $condition";
			$result_set = static::process_rows($database->query($query_sql));

			return !empty($result_set) ? true : false; 
			//array_shift($result_set)
		}
		
		public function save() {
		  // A new record won't have an id yet.
			// echo print_r($this);
		  return isset($this->id) ? $this->update() : $this->create();
		}
		
		public function create() {
			global $database;

			$san_attributes = $this->sanitized_attributes();

			$attributes = array_filter($san_attributes, function($k) {
			    return $k != "id";
			}, ARRAY_FILTER_USE_KEY);

		  	$sql = "INSERT INTO ".static::get_table()." (";
			$sql .= join(", ", array_keys($attributes));
		 	
		 	$sql .= ") VALUES ('";
			$sql .= join("', '", array_values($attributes));
			$sql .= "')";
		  	
		  	if($database->query($sql)) {
		    	$this->id = $database->insert_id();
				return $this->id = $database->insert_id();
			} else {
				return false;
			}
		}

		public function update() {
		  	global $database;
			
			$attributes = $this->sanitized_attributes();
			$attribute_pairs = array();
			
			foreach($attributes as $key => $value) {
			  $attribute_pairs[] = "{$key}='{$value}'";
			}
			
			$sql = "UPDATE ".static::get_table()." SET ";
			$sql .= join(", ", $attribute_pairs);
			$sql .= " WHERE id=". $database->escape_value($this->id);
		  	
		  	$database->query($sql);
		  	
		  	return ($database->affected_rows() == 1) ? true : false;
		}

		public function delete() {
			global $database;
			$sql = "DELETE FROM ".static::get_table();
			$sql .= " WHERE id=". $database->escape_value($this->id);
			$sql .= " LIMIT 1";
			$database->query($sql);

			return ($database->affected_rows() == 1) ? true : false;
		}

		public function process_rows($result){
			global $database;
			$object_array = array();

			while ($row = $database->fetch_array($result)) {
			  $object_array[] = static::to_oject($row);
			}

			return $object_array;
		}

		public static function from_array($array){
			$object = new static;

			foreach ($array as $key => $value) {
			  if($object->has_attribute($key)){
			    $object->$key = $value;
			  }
			}
			
			return $object;
		}

		private static function to_oject($cursor){
			$object = new static;

			foreach ($cursor as $key => $value) {
			  if($object->has_attribute($key)){
			    $object->$key = $value;
			    // echo $object->$key;
			  }
			}

			return $object;
		}

		private function has_attribute($attribute){
			$vars = $this->attributes();
			return array_key_exists($attribute, $vars);
		}

		// MIGRATIONS
		public function migrate_up(){
			global $database;
			$table_name = static::$table_name;
			$table_creating_query = static::table_creating_query();

			$query  = "CREATE TABLE IF NOT EXISTS `$table_name` ($table_creating_query)";

			$clean_query = str_replace("<br/>", "", $query);
			
			if($database->query($clean_query)){
				echo "$table_name table successfully created!<br/>";
			}
		}

		public function migrate_down(){
			global $database;
			$table_name = static::$table_name;
			$query  = "DROP TABLE IF EXISTS `$table_name`";
			
			if($database->query($query)){
				echo "$table_name table successfully deleted!<br/>";
			}
		}
	}
?>