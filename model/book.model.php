<?php 
//using active record
class Book{ 
	public $db;
	public $author_id;
	public $description;
	public $title;
	public $status_id;
	public $id;

	function __construct($db){
		$this->db = $db;
	}

	public function save(){
		if(!empty($this->id)){
			$sql = "
				UPDATE book 
				SET 
					title = :title,
					description = :description,
					author_id = :author_id,
					status_id = :status_id
				WHERE id = :id
			";

			$state = $this->db->prepareSql($sql);
			$state->setParam('title','\''.$this->title.'\'')
				->setParam('description','\''.$this->description.'\'')
				->setParam('author_id',$this->author_id)
				->setParam('status_id',$this->status_id)
				->setParam('id',$this->id)
				->exec();
		}else{
			$sql = "
				INSERT INTO book 
					(title,description,author_id,status_id)
					VALUES (:title,:description,:author_id,:status_id)
			";

			$state = $this->db->prepareSql($sql);
			$this->book_id = 
				$state->setParam('title','\''.$this->title.'\'')
					->setParam('description','\''.$this->description.'\'')
					->setParam('author_id',$this->author_id)
					->setParam('status_id',$this->status_id)
					->exec()
					->getLastInsertId();
		}
	}
	
	public function getData(){
		$sql = "
			SELECT *
			FROM book
			WHERE 1=1
				".($this->id?"AND id = ".$this->id:"")."
				".($this->author_id?"AND author_id = ".$this->author_id:"")."
				".($this->status_id?"AND status_id = ".$this->status_id:"")."
				".($this->title?"AND status LIKE '".$this->author_id."'":"")."
				".($this->description?"AND description LIKE '".$this->description."'":"")."
		";

		$state = $this->db->prepareSql($sql);
		$handler = $state->exec();
		/*
		$books_array = [];
		while($row = $books->getRow()){
			$books_array[] = $row;
		}
		*/
		$data_array = $handler->getRows();
		return $data_array;
	}
	

}

#eof