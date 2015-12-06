<?php 
//using active record
class Author{ 
	public $db;
	public $name;
	public $id;

	function __construct($db){
		$this->db = $db;
	}

	public function save(){
		if(!empty($this->id)){
			$sql = "
				UPDATE author 
				SET 
					name = :name
				WHERE id = :id
			";

			$state = $this->db->prepareSql($sql);
			$state->setParam('name',"'".$this->name."'")
				->setParam('id',$this->id)
				->exec();
		}else{
			$sql = "
				INSERT INTO author 
					(name)
					VALUES (:name)
			";

			$state = $this->db->prepareSql($sql);
			$this->book_id = 
				$state->setParam('name','\''.$this->name.'\'')
					->exec()
					->getLastInsertId();
		}
	}
	
	public function getData(){
		$sql = "
			SELECT *
			FROM author
			WHERE 1=1
				".($this->id?"AND id = ".$this->id:"")."
				".($this->name?"AND name LIKE '".$this->name."'":"")."
		";
		$state = $this->db->prepareSql($sql);
		$handler = $state->exec();

		$data_array = $handler->getRows();
		return $data_array;
	}
	

}

#eof