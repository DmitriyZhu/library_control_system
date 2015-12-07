<?php

require_once('model/db.php');
require_once('model/book.model.php');
require_once('model/author.model.php');
require_once('model/status.model.php');

$db = new db('my',true);
//$db->iterateVisible();
$book = new Book($db);
$author = new Author($db);
$status = new Status($db);


$author->name = 'Aнтон Павлович Чехов';
$arr = $author->save();
$arr = $author->getData();

/*
$book->title = 'Book';
$book->description = 'Description';
$book->status_id = 1;
$book->save();
$status->name = 'avalible';
$status->save();
$status->name = 'unavalible';
$status->save();
$status->name = 0;
$status->getData();
*/

#EOF