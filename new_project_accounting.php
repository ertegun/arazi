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
$project_accounting_id = $db->lastInsertId();

$project_accounting_insert = 0;
if ($insert) {
  $project_accounting_insert = 1;

  // if (($type_id == 1 || $type_id == 2) && $grower_id > 0)//$type_id=KASA/GÖTÜRÜ
  if ($expense_type_id == 2 && $grower_id > 0)//$expense_type_id=2=>çiftçi ödemesi
  {
    $sql = "INSERT INTO grower_accounting SET
    grower_id = :grower_id,
    branch_id = :branch_id,
    project_id = :project_id,
    project_accounting_id =:project_accounting_id,
    alacak_verecek = :alacak_verecek,
    process_date = :process_date
  ";
    $query = $db->prepare($sql);
    $params = array(
      "grower_id" => "$grower_id",
      "branch_id" => "$branch_id",
      "project_id" => "$project_id",
      "project_accounting_id" => "$project_accounting_id",
      "alacak_verecek" => "$amount",
      "process_date" => "$process_date",
    );
    $insert = $query->execute($params);
  }
  // function echoSql($sql, $params)
  // {
  //   $indexed = $params == array_values($params);
  //   foreach ($params as $k => $v) {
  //     if (is_string($v)) {
  //       $v = "'$v'";
  //     }
  //     if ($indexed) {
  //       $sql = preg_replace('/\?/', $v, $sql, 1);
  //     } else {
  //       $sql = str_replace(":$k", $v, $sql);
  //     }
  //   }
  //   echo $sql;
  // }

}
// echoSql($sql, $params);

print $project_accounting_insert;

if ($expense_type_id == 1)//malzeme gideri ise 1 ozaman stoktan düşeceğiz
{
  $sql = "UPDATE material_stock SET used_quantity=used_quantity+$material_quantity WHERE id=$material_id";
  // Prepare statement

  $stmt = $db->prepare($sql);
  // execute the query
  $stmt->execute();
}