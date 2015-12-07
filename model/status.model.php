<?php


class Status{
	public $db;
	public $name;
	public $id;

	function __construct($db){
		$this->db = $db;
	}

	public function save(){
		if(!empty($this->id)){
			$sql = "
				UPDATE book_status 
				SET 
					name = :name
				WHERE id = :id
			";

			$state = $this->db->prepareSql($sql);
			$state
				->setParam('name',"'".$this->name."'")
				->setParam('id',$this->id)
				->exec();
		}else{
			$sql = "
				INSERT INTO book_status 
					(name)
					VALUES (:name)
			";

			$state = $this->db->prepareSql($sql);
			$this->book_id = 
				$state
					->setParam('name',"'".$this->name."'")
					->exec()
					->getLastInsertId();
		}
	}
	
	public function getData(){
		$sql = "
			SELECT *
			FROM book_status
			WHERE 1=1
				".($this->id?"AND id = :id":"")."
				".($this->name?"AND name LIKE :name":"")."
		";
		$state = $this->db->prepareSql($sql);
		$handler = $state
				->setParam('name',"'".$this->name."'")
				->setParam('id',$this->id)
				->exec();

		$data_array = $handler->getRows();
		return $data_array;
	}



}


#EOF