<?php

require_once('model/db.php');
require_once('model/book.class.php');

$db = new db('my',true);
//$db->iterateVisible();
$book = new Book($db);

$book->author_id = 1;
$arr = $book->getData();
print_r($arr);

/*
$book->title = 'Book';
$book->description = 'Description';
$book->status_id = 1;
$book->save();
*/


#EOF