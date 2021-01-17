<?php
	
/*
| -----------------------------------------------------------------------------------------------------------
| REMEMBER, When You Write NORMAL SQL_Query, put an single/double Quotes for the Values
| like: '{$name}', '{$roll}', '{$address}', '{$id}'
| $sql = "UPDATE {$table} SET name = '{$name}', roll = '{$roll}', address = '{$address}' WHERE id = '{$id}'";
| -- But For Integer Value You may omit the Quotes...
| -----------------------------------------------------------------------------------------------------------
| Don't Put single/Double Quote for Question mark Parameter (?) and Named Parameter (:name)
| like, Question mark Parameter (?):
| 		$sql = "UPDATE {$table} SET name = ?, roll = ?, address = ? WHERE id = ?";
| Named-PlaceHolder Parameter (:data):
| 		$sql = "UPDATE {$table} SET name = :name, roll = :roll, address = :address WHERE id = :id";
| ---------------------------------------------------------------------------------------------------------
| Put An Extra Quote (Single/Double) for bindValue() / bindParam() When You Use Nameed-PlaceHolder
| like: 		bindValue(":name", $name);			And, 		bindParam(":name", $name);
| ----------------------------------------------------------------------------------------------------------
| We Didn't Use bindParam Here.. You've to Write a Slightly Different Query For That
| ----------------------------------------------------------------------------------------------------------
*/

class DB {

	private $_db_user = DB_USER,
			$_db_pass = DB_PASS,
			$_dsn	 = "mysql:host=". DB_HOST . "; dbname=" . DB_NAME . ";",
			$_query,
			$_stmtObj,
			$_results = [],
			$_resultsAll = [],
			$_rawQueryData = [],
			$_numberOfRows = 0,
			$_action = false,
			$_actionType = false,
			$_errors = false;
	public static $pdo;

	public function __construct() {
		$this->connectDB();
			// For Security Reason, It is Better to Use try-Catch Block to Connect
			// & Get Error in terms of Any Database Related Metter..
	}

	public function connectDB() {
		if(!isset(self::$pdo)) {
			try {
				// $conn = new PDO("mysql:host=localhost; dbname=gs_crud;", "root", "");
				self::$pdo = new PDO($this->_dsn, $this->_db_user, $this->_db_pass);
				self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$pdo->exec( "SET CHARACTER SET utf8" );
					// inside exec() method the string "SET CHARACTER SET utf8" is a built in, 
					// you can't change it.. you must be wittern like: 'utf8' not 'utf-8' ..remember this..
				// echo "Connection Successful <br>";
			} catch( PDOException $e ) {
				//echo $e->getMessage() . "<br>";	// Debugging Method..
					// This Line Must Not use for Client or Professional pupose,
					// Bcoz, $e->getMessage() shows the Error Message & Database name
					// in the Browser, which is Not SAFE...
					// Using Only to find DEVELOPER's Debuggings Purpose..
				die("404 NOT FOUND");
			}
			
		}
	}
	
	// Select/Read Individual/Particular Data with Question-Mark/Positional...
	public function select($table) {
		$action = "SELECT * FROM {$table} ";
		$this->_action = $action;
		$this->_actionType = "SELECT";
		return $this;
	}

	// Select All/Read ALl Data with Question-Mark/Positional Placeholder
	public function selectAll($table) {
	$sql = "SELECT * FROM {$table}";
		if(!$this->questionMarkQuery($sql)->errors()) {
			return $this->stmtObj();
		}
		return false;
	}

	// Select/Read Individual/Particular Data with Name Placeholder
	public function read($table) {
		$action = "SELECT * FROM {$table} ";
		$this->_action = $action;
		$this->_actionType = "READ";
		return $this;
	}

	// Select All/Read ALl Data with Name Placeholder
	public function readAll($table) {
		$sql = "SELECT * FROM {$table}";
		if(!$this->questionMarkQuery($sql)->errors()) {
			return $this->stmtObj();
		}
		return false;
	}

	// Update/Edit Data with Question-Mark/Positional Placeholder
	public function update($table, $array = []) {
		$action = "UPDATE {$table} SET ";
		$this->_action = $action;
		$this->_actionType = "UPDATE";
		$this->_rawQueryData = $array;
		return $this;
	}

	// Update/Edit Data with Name Placeholder
	public function edit($table, $array = []) {
		$action = "UPDATE {$table} SET ";
		$this->_action = $action;
		$this->_actionType = "EDIT";
		$this->_rawQueryData = $array;
		return $this;
	}

	// Insert/Create Data with Question-Mark/Positional Placeholder
	public function insert($table, $array=[]) {
		$data_keys 	 = $this->input_keys($array);
		$data_values = $this->questionMarkPlaceholder($array);
		$sql = "INSERT INTO {$table}($data_keys) VALUE($data_values)";
		if( !$this->questionMarkQuery($sql, $array)->errors() ) {
			return $this->stmtObj();
		}
		return false;
	}

	// Insert/Create Data with Name Placeholder with execute()...
	public function create($table, $array=[]) {
		$data_keys 	 = $this->input_keys($array);
		$data_values = $this->namedPlaceholder($array);
		$sql = "INSERT INTO {$table}($data_keys) VALUE($data_values)";
		if( !$this->namedQuery($sql, $array)->errors() ) {
			return $this->stmtObj();
		}
		return false;
	}

	// DELETE Data with Question-Mark/Positional Placeholder with execute()...
	public function delete($table) {
		$action = "DELETE FROM {$table} ";
		$this->_action = $action;
		$this->_actionType = "DELETE";
		return $this;
	}

	// DELETE Data with Name Placeholder with execute()...
	public function del($table) {
		$action = "DELETE FROM {$table} ";
		$this->_action = $action;
		$this->_actionType = "DEL";
		return $this;
	}

	// Common Query for Question-Mark/Positional Placeholder
	public function questionMarkQuery($sql, $datas = []) {
		if( $this->_query = self::$pdo->prepare($sql) ) {
			if( count($datas) ) {
				$i = 1;
				foreach( $datas as $data_key => $data_value ) {
					$this->_query->bindValue( $i, $data_value );
					$i+=1;
				}
			}

			if( $this->_query->execute() ) {
				$this->_stmtObj = $this->_query; 
				//$this->_resultsAll = $this->_query->fetchAll(PDO::FETCH_ASSOC);
				//$this->_results = $this->_query->fetch(PDO::FETCH_ASSOC);
				//$this->_numberOfRows = $this->_query->rowCount();
			} else {
				$this->_errors = true;
			}
		}
		return $this;
	}

	// Common Query for Named Placeholder
	public function namedQuery($sql, $datas = []) {
		if( $this->_query = self::$pdo->prepare($sql) ) {
			if( count($datas) ) {
				foreach( $datas as $data_key => $data_value ) {
					$this->_query->bindValue( ":{$data_key}", $data_value );
				}
			}

			if( $this->_query->execute() ) {
				$this->_stmtObj = $this->_query; 
				//$this->_resultsAll = $this->_query->fetchAll(PDO::FETCH_ASSOC);
				//$this->_results = $this->_query->fetch(PDO::FETCH_ASSOC);
				//$this->_numberOfRows = $this->_query->rowCount();
			} else {
				$this->_errors = true;
			}
		}
		return $this;
	}

	// Where Caluse for All..
	public function where(...$where) {
		if(isset($where) && count($where) == 3 && $this->_action && $this->_actionType) {
			$where_key = $where[0];
			$where_operator = $where[1];
			$where_value = $where[2];
			$where_operators = ["=", "<", ">", "<=", ">=", "!="];
			if(in_array($where_operator, $where_operators)) {	// Validation..
				$where_operator = $where[1];
			} else {
				return false;
			}
			
			if( count($this->_rawQueryData) && $this->_actionType == "UPDATE" ) {
				$sql = $this->_action;
				$len = count($this->_rawQueryData);
				$counter = 0;
				foreach($this->_rawQueryData as $key => $value) {
					$sql .= "{$key} = ?";
					if($counter != ($len - 1)) {
						$sql .= ", ";
					}
					$counter++;
				}
				$sql .= " WHERE {$where_key} = ?";
				$data = $this->_rawQueryData;
				$data["id"] = $where_value;
				if(!$this->questionMarkQuery($sql, $data)->errors()) {
					return $this->stmtObj();
				}
			} else if( count($this->_rawQueryData) && $this->_actionType == "EDIT" ) {
				$sql = $this->_action;
				$len = count($this->_rawQueryData);
				$counter = 0;
				foreach($this->_rawQueryData as $key => $value) {
					$sql .= "{$key} = :{$key}";
					if($counter != ($len - 1)) {
						$sql .= ", ";
					}
					$counter++;
				}
				$sql .= " WHERE {$where_key} = :{$where_key}";
				$data = $this->_rawQueryData;
				$data["id"] = $where_value;
				if(!$this->namedQuery($sql, $data)->errors()) {
					return $this->stmtObj();
				}
			} else {
				if( !count($this->_rawQueryData) && $this->_actionType == "SELECT" ) {
					$sql = "{$this->_action} WHERE {$where_key} {$where_operator} ?";
					$data = [$where_key => $where_value];
					if(!$this->questionMarkQuery($sql, $data)->errors()) {
						return $this->stmtObj();
					}
					return false;
				} else if( !count($this->_rawQueryData) && $this->_actionType == "READ" )  {
					$sql = "{$this->_action} WHERE {$where_key} {$where_operator} :{$where_key}";
					$data = [$where_key => $where_value];
					if(!$this->namedQuery($sql, $data)->errors()) {
						return $this->stmtObj();
					}
					return false;
				} else if( !count($this->_rawQueryData) && $this->_actionType == "DELETE" ) {
					$sql = "{$this->_action} WHERE {$where_key} {$where_operator} ?";
					$data = [$where_key => $where_value];
					if(!$this->questionMarkQuery($sql, $data)->errors()) {
						return $this->stmtObj();
					}
					return false;
				} else if( !count($this->_rawQueryData) && $this->_actionType == "DEL" ) {
					$sql = "{$this->_action} WHERE {$where_key} {$where_operator} :{$where_key}";
					$data = [$where_key => $where_value];
					if(!$this->namedQuery($sql, $data)->errors()) {
						return $this->stmtObj();
					}
					return false;
				}
				return false;
			}
		}
		return false;
	}

	// Helper Method - 1 (for Insert/Create Method)
	public function input_keys($array=[]) {
		// array_pop($array);	// WE used array_pop() in Validation, That's why we removed it from here
		$keys = array_keys($array);
		$keys = implode(", ", $keys);
		return $keys;
	}

	// Helper Method - 2 (for Insert/Create Method)
	public function input_values($array=[]) {
		// array_pop($array);	// WE used array_pop() in Validation, That's why we removed it from here
		$values = array_values($array);
		$len = count($values);
		for($i = 0; $i < $len; $i+=1) {
			$values[$i] = "'".$values[$i]."'";
		}
		$values = implode(", ", $values);
		return $values;
	}

	// Helper Method - 3 (for Insert/Create Method, For Question-Mark PlaceHolder)
	public function questionMarkPlaceholder($array=[]) {
		// array_pop($array);	// WE used array_pop() in Validation, That's why we removed it from here
		$values = [];
		$len = count($array);
		for($i = 0; $i < $len; $i+=1) {
			$values[$i] = "?";
		}
		$r = implode(",", $values);
		return $r;
	}

	// Helper Method - 4 (for Insert/Create Method, For Named-PlaceHolder)
	public function namedPlaceholder($array=[]) {
		// array_pop($array);	// WE used array_pop() in Validation, That's why we removed it from here
		$values = [];
		$len = count($array);
		$i = 0;
		foreach($array as $key => $value) {
			$values[$i] = ":{$key}";
			$i++;
		}
		$r = implode(", ", $values);
		return $r;
	}

	// Returns the OBJECT Returned By the Prepared Statement After execute()
	// We Can Use this OBJECT Later 
	// to access rowCount(), fetch(PDO::FETCH_OBJ), fetchAll(PDO::FETCH_OBJ) etc. Methods
	public function stmtObj() {
		return $this->_stmtObj;
	}

	public function errors() {
		return $this->_errors;
	}

	// Connection Close 
	public function connectionClose() {	// best practice
		return self::$pdo = "";
	}


	/*
	| ---------------------------------------------------------------------------------
	| The Reaming Methods From Here, of This File Was Created, But Not Used / Initilized
	| Values, You May Use it Latter. But These Are Still Unused
	| ---------------------------------------------------------------------------------
	*/

	// Here we Used fetch() Method
	public function results() {
		return $this->_results;
	}
	
	// Here we Used fetchAll() Method
	public function resultsAll() {
		return $this->_resultsAll;
	}


	public function resultsFirst() {
		return $this->_results[0];
	}

	public function numberOfRows() {
		return $this->_numberOfRows;
	}

	

	


}	// class DB End here...................................


?>