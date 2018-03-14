<?php
include 'adodb.inc.php';

$db = ADONewConnection('mysqli');
$db->connect('localhost', 'root', 'C0yote71', 'test');

$sql = 'insert into mytable values()';

//$db->execute($sql);
//var_dump($db->Insert_ID());

//$db->beginTrans();
//$db->execute($sql);
//var_dump($db->Insert_ID());
//$db->commitTrans();

$db->beginTrans();
$db->execute($sql);
var_dump($db->Insert_ID());
$db->commitTrans();
var_dump($db->Insert_ID());
