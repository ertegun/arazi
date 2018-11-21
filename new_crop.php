<?php

/* yeni ürün tipi ekler */
include './connection.php';

extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.

$query = $db->prepare("INSERT INTO crop SET
name = :name
");

$insert = $query->execute(array(
  "name" => "$name"
  ));

if ($insert)
{
  $last_id = $db->lastInsertId();
  print $last_id;
}