<?php

/* kullanımda yok */
include './connection.php';

extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.

$query = $db->prepare("INSERT INTO branch_accounting SET
branch_id =:branch_id ,
project_id = :project_id,
type_id = :type_id,
name = :name,
amount = :amount,
operation_date = :operation_date,
description = :description
");

$insert = $query->execute(array(
  "branch_id" => "$branch_id",
  "project_id" => "$project_id",
  "type_id" => "$type_id",
  "name" => "$name",
  "amount" => "$amount",
  "operation_date" => "$operation_date",
  "description" => "$description"
  ));

if ($insert)
{
  $last_id = $db->lastInsertId();
  print 1;
}