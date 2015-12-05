<?php

class db{

	private $config;
	private $errors;
	private $connection_id;
	private $db_type;
	private $sql;
	private $res;
	private $verbose;


	private static $errBegin = "<div style='background-color:pink'><strong><font color='red'>";
	private static $errEnd = "</font></strong></div>";

	function __construct($db_name,$verbose=false){
		$this->verbose = $verbose;
		$this->config = $this->getDbConfig($db_name);
		$this->db_type = $this->config['type'];

		switch($this->db_type){
			case 'mysql':
				$this->connection_id = $this->mysqlGetConnection($this->config);
				break;
			default:
				$this->generateErrString('Wrong db type');
				break;
		}
	}

	//-------sql functions-----------

	private function mysqlGetConnection($connectionArray){
		$cid = @mysql_connect(
				$connectionArray['adress'],
				$connectionArray['usr'],
				$connectionArray['pswd']
			) or die($this->generateErrString(mysql_error()));
		if(!empty($connectionArray['db'])){
			mysql_select_db($connectionArray['db']) 
				or die($this->generateErrString(mysql_error()));
		}
	}

	public function prepareSql($sql){
		switch($this->db_type){
			case 'mysql':
				$this->sql = mysql_real_escape_string($sql);
				$this->sql = str_replace('\n', '', $this->sql);

				break;
			default:
				break;
		}

		return $this;
	}

	public function exec(){
		switch($this->db_type){
			case 'mysql':
				$this->res = mysql_query($this->sql) 
					or die($this->generateErrString(mysql_error()));
				break;
			default:
				break;
		}
		return $this;
	}

	public function getRow(){
		switch($this->db_type){
			case 'mysql':
				return mysql_fetch_row($this->res);
				break;
			default:
				break;
		}
	}

	public function getRows(){
		switch($this->db_type){
			case 'mysql':
				$rows = [];
				while($row = mysql_fetch_row($this->res)){
					$rows[] = $row;
				}
				return $rows;
				break;
			default:
				break;
		}
	}

	public function getLastInsertId(){
		switch($this->db_type){
			case 'mysql':
				return mysql_insert_id();
				break;
			default:
				break;
		}
	}

	//-----other functions------

	public function setParam($name,$val){
		$this->sql = str_replace(':'.$name, $val, $this->sql);
		return $this;
	}

	private function generateErrString($err){
		$errString = self::$errBegin.$err.self::$errEnd;
		$errString = str_replace('\n', '<br>', $errString);
		return $this->verbose?$errString:'';
	}

	private function getDbConfig($db_name){
		$configArray = parse_ini_file('config.ini',true);
		return $configArray[$db_name];
	}

	public function iterateVisible(){
		echo '<pre>';
		print_r($this);
	}

}




#EOF