<?php

/* Yeni proje tanımla */
include './connection.php';

extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.

function echoSql($sql, $params)
{
  $indexed = $params == array_values($params);
  foreach ($params as $k => $v) {
    if (is_string($v)) {
      $v = "'$v'";
    }
    if ($indexed) {
      $sql = preg_replace('/\?/', $v, $sql, 1);
    } else {
      $sql = str_replace(":$k", $v, $sql);
    }
  }
  return $sql;
}

$sql = "INSERT INTO project SET
branch_id = :branch_id,
type_id = :type_id,
grower_id = :grower_id,
crop_id = :crop_id,
name = :name,
field_area = :field_area,
agreed_amount = :agreed_amount,
unit_type_id = :unit_type_id,
qty_per_unit = :qty_per_unit,
unit_price = :unit_price,
start_date = :start_date,
planting_quantity = :planting_quantity,
expected_quantity = :expected_quantity,
expected_duration = :expected_duration,
expected_end_date = :expected_end_date,
description = :description";
$params = array(
  "branch_id" => "$branch_id",
  "type_id" => "$type_id",
  "grower_id" => "$grower_id",
  "crop_id" => "$crop_id",
  "name" => "$name",
  "field_area" => "$field_area",
  "agreed_amount" => "$agreed_amount",
  "unit_type_id" => "$unit_type_id",
  "qty_per_unit" => "$qty_per_unit",
  "unit_price" => "$unit_price",
  "start_date" => "$start_date",
  "planting_quantity" => "$planting_quantity",
  "expected_quantity" => "$expected_quantity",
  "expected_duration" => "$expected_duration",
  "expected_end_date" => "$expected_end_date",
  "description" => "$description"
);
$query = $db->prepare($sql);
$insert = $query->execute($params);
//var_dump($paramjson);
//
//echo echoSql($sql, $paramjson);
//exit;

if ($insert && ($type_id == 1 || $type_id == 2))//$type_id=KASA/GÖTÜRÜ
{
  $project_id = $db->lastInsertId();
  $query = $db->prepare("INSERT INTO grower_accounting SET
    grower_id = :grower_id,
    branch_id = :branch_id,
    project_id = :project_id,
    alacak_verecek = :alacak_verecek,
    process_date = :process_date
  ");

  $insert = $query->execute(array(
    "grower_id" => "$grower_id",
    "branch_id" => "$branch_id",
    "project_id" => "$project_id",
    "alacak_verecek" => $agreed_amount * (-1), //BORÇ NEGATİF
    "process_date" => "$process_date"
  ));
  if ($insert) {
    print "1";
  } else {
    print "0";
  }
  exit();
}

if ($insert) {
  print "1";
}