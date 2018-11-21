<?php

/*
  Kasa hesabında yapılan giriş çıkış işlemlerini yapar
 */

include './connection.php';

extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.

$query = $db->prepare("INSERT INTO safe_accounting SET
branch_id = :branch_id,
purchaser_id = :purchaser_id ,
type_id = :type_id,
project_id = :project_id,
expense_type_id = :expense_type_id,
name = :name,
amount = :amount,
description = :description
");

$insert = $query->execute(array(
  "branch_id" => "$branch_id",
  "purchaser_id" => "$purchaser_id",
  "type_id" => "$type_id",
  "project_id" => "$project_id",
  "expense_type_id" => "$expense_type_id",
  "name" => "$name",
  "amount" => "$amount",
  "description" => "$description"
  ));

if ($insert)
{
  $last_id = $db->lastInsertId();
  print $last_id;
}