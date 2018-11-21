<?php

/* Projeye kesim ekle */
include './connection.php';
extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.
// $fp = fopen('results.json', 'w');
// fwrite($fp, json_encode($_POST));
// fclose($fp);
$query = $db->prepare("INSERT INTO project_reap SET
branch_id =:branch_id,
project_id =:project_id,
crop_id = :crop_id,
reap_date = :reap_date,
quantity_per_unit = :quantity_per_unit,
unit_type_id = :unit_type_id,
reap_quantity = :reap_quantity
");

$insert = $query->execute(array(
  "branch_id" => "$branch_id",
  "project_id" => "$project_id",
  "crop_id" => "$crop_id",
  "reap_date" => "$reap_date",
  "quantity_per_unit" => "$quantity_per_unit",
  "unit_type_id" => "$unit_type_id",
  "reap_quantity" => "$reap_quantity"
));

$project_reap_id = $db->lastInsertId();

if ($insert) {
  $sql = "INSERT INTO project_accounting SET
  branch_id =:branch_id,
  project_id =:project_id,
  type_id = :type_id,
  purchaser_id = :purchaser_id,
  unit_sales_price = :unit_sales_price,
  quantity = :quantity,
  amount = :amount,
  description = :description,
  operation_date = :operation_date,
  -- unit_sales_price = :unit_sales_price,
  project_reap_id = :project_reap_id ";
  $query = $db->prepare($sql);
  $params = array(
    "branch_id" => "$branch_id",
    "project_id" => "$project_id",
    "type_id" => "1",
    "purchaser_id" => "$purchaser_id",
    "unit_sales_price" => "$unit_sales_price",
    "quantity" => "$reap_quantity",
    "amount" => "$amount",
    "operation_date" => "$reap_date",
    // "unit_sales_price" => "$unit_sales_price",
    "description" => "$description",
    "project_reap_id" => $project_reap_id
  );

  $insert2 = $query->execute($params);
  $project_accounting_id = $db->lastInsertId();
  if ($insert2) {
    print 1;
  } else {
    print 0;
  }


  $query = $db->prepare("INSERT INTO purchaser_accounting SET
purchaser_id = :purchaser_id,
branch_id =:branch_id,
project_id =:project_id,
project_accounting_id =:project_accounting_id,
crop_id = :crop_id,
satilan_birim_fiyat = :satilan_birim_fiyat,
satilan_miktar = :satilan_miktar,
satilan_birim = :satilan_birim,
odenen_para = :odenen_para,
operation_date = :operation_date
");

  $insert = $query->execute(array(
    "purchaser_id" => "$purchaser_id",
    "branch_id" => "$branch_id",
    "project_id" => "$project_id",
    "project_accounting_id" => "$project_accounting_id",
    "crop_id" => "$crop_id",
    "satilan_birim_fiyat" => "$satilan_birim_fiyat",
    "satilan_miktar" => "$satilan_miktar",
    "satilan_birim" => "$satilan_birim",
    "odenen_para" => "$amount",
    "operation_date" => "$reap_date",
  ));

  $purchaser_accounting_insert = 0;
  if ($insert) {
//  $last_id = $db->lastInsertId();
    $purchaser_accounting_insert = 1;
  }
  print $purchaser_accounting_insert;

// Proje tablosundaki quantity alanı da güncellenecek
//$sql = "UPDATE material_stock SET used_quantity=used_quantity+$material_quantity WHERE id=$material_id";
//Prepare statement
//$stmt = $db->prepare($sql);
//execute the query
//$stmt->execute();
}