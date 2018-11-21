<?php

/* Kullanımda değil */
include './connection.php';

class Material_Stock_Info
{

  public $id;
  public $branch_id;
  public $material_id;
  public $quantity;
  public $unit_type;
  public $unit_price;
  public $amount;
  public $used_quantity;
  public $is_all_used;
  public $entry_date;

}

$query = $db->query("SELECT * FROM material_stock", PDO::FETCH_ASSOC);

if ($query->rowCount())
{
  foreach ($query as $row) {
    $material_stock_info = new Material_Stock_Info();
    $material_stock_info->id = $row['id'];
    $material_stock_info->branch_id = $row['branch_id'];
    $material_stock_info->material_id = $row['material_id'];
    $material_stock_info->quantity = $row['quantity'];
    $material_stock_info->unit_type = $row['unit_type'];
    $material_stock_info->unit_price = $row['unit_price'];
    $material_stock_info->amount = $row['amount'];
    $material_stock_info->used_quantity = $row['used_quantity'];
    $material_stock_info->is_all_used = $row['is_all_used'];
    $material_stock_info->entry_date = $row['entry_date'];
    $data[] = $material_stock_info;
  }

  echo json_encode($data);
}