<?php

/* yeni malzeme stoğu ekle */
include './connection.php';

extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.

$query = $db->prepare("INSERT INTO material_stock SET
branch_id = :branch_id,
material_id = :material_id,
quantity = :quantity,
unit_type = :unit_type,
unit_price = :unit_price,
amount = :amount,
is_safe_paid = :is_safe_paid
");

$insert = $query->execute(array(
  "branch_id" => "$branch_id",
  "material_id" => "$material_id",
  "quantity" => "$quantity",
  "unit_type" => "$unit_type",
  "unit_price" => "$unit_price",
  "amount" => "$amount",
  "is_safe_paid" => "$is_safe_paid"
  ));

if ($insert)
{
  $last_id = $db->lastInsertId();
  print $last_id;
}