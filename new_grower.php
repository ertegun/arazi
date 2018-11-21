<?php

/* Çiftçi ekle */
include './connection.php';

extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.

$query = $db->prepare("INSERT INTO grower SET
branch_id = :branch_id,
name = :name,
surname = :surname
");

$insert = $query->execute(array(
  "branch_id" => "$branch_id",
  "name" => "$name",
  "surname" => "$surname"
  ));

if ($insert)
{
  // $last_id = $db->lastInsertId();
  print 1;
}