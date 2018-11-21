<?php

/* kullanımda değil */
include './connection.php';

extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.

$query = $db->prepare("INSERT INTO internal_field_accounting SET
project_id =:project_id,
type_id = :type_id,
name = :name,
process_date = :process_date,
purchaser_id = :purchaser_id,
unit_sales_price = :unit_sales_price,
quantity = :quantity,
amount = :amount,
description = :description
");

$insert = $query->execute(array(
  "project_id" => "$project_id",
  "type_id" => "$type_id",
  "name" => "$name",
  "process_date" => "$process_date",
  "purchaser_id" => "$purchaser_id",
  "unit_sales_price" => "$unit_sales_price",
  "quantity" => "$quantity",
  "amount" => "$amount",
  "description" => "$description"
  ));

if ($insert)
{
  $last_id = $db->lastInsertId();
  print 1;
}