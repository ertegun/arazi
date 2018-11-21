<?php

/* Projeye işlem ekle */
include './connection.php';

extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.

$query = $db->prepare("INSERT INTO project_accounting SET
branch_id = :branch_id,
project_id = :project_id,
type_id = :type_id,
expense_type_id = :expense_type_id,
material_id = :material_id,
material_quantity = :material_quantity,
purchaser_id = :purchaser_id,
unit_sales_price = :unit_sales_price,
quantity = :quantity,
amount = :amount,
description = :description,
operation_date = :operation_date,
is_safe_paid = :is_safe_paid
");

$insert = $query->execute(array(
  "branch_id" => "$branch_id",
  "project_id" => "$project_id",
  "type_id" => "$type_id",
  "expense_type_id" => "$expense_type_id",
  "material_id" => "$material_id",
  "material_quantity" => "$material_quantity",
  "purchaser_id" => "$purchaser_id",
  "unit_sales_price" => "$unit_sales_price",
  "quantity" => "$quantity",
  "amount" => "$amount",
  "description" => "$description",
  "operation_date" => "$process_date",
  "is_safe_paid" => "$is_safe_paid"
));

if ($insert) {
  $last_id = $db->lastInsertId();
  print 1;
}

if ($expense_type_id == 1)//malzeme gideri ise 1 ozaman stoktan düşeceğiz
{
  $sql = "UPDATE material_stock SET used_quantity=used_quantity+$material_quantity WHERE id=$material_id";
  // Prepare statement

  $stmt = $db->prepare($sql);
  // execute the query
  $stmt->execute();
}