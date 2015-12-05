<?php 
//using active record
class Book{ 
	public $db;
	public $author_id;
	public $description;
	public $title;
	public $status_id;
	public $book_id;

	static $fields = [];

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
				WHERE book_id = :book_id
			";
			$state = $this->db->prepareSql($sql);
			$state->setParam('title',$this->title)
				->setParam('description',$this->description)
				->setParam('author_id',$this->author_id)
				->setParam('status',$this->status_id)
				->setParam('book_id',$this->book_id)
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
	
	

}

#eof