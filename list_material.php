<?php

/* Malzemeleri listeler */
include './connection.php';

extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.

class Material_List_Info
{

  public $id;
  public $branch_id;
  public $material_id;
  public $name;
  public $unit_type;
  public $unit_price;
  public $amount;
  public $used_quantity;
  public $is_all_used;
  public $is_safe_paid;
  public $entry_date;

}

if ($branch_id == '')
{
  echo json_encode(['Şube id boş olamaz!']);
  exit();
}

$column = 'ms.id,branch_id,material_id,name,unit_type,unit_price,amount,quantity,used_quantity,is_all_used,is_safe_paid,entry_date';
$sql = "SELECT $column FROM material_stock AS ms JOIN material AS m ON m.id=ms.material_id "
  . " WHERE branch_id=$branch_id";

$query = $db->query($sql, PDO::FETCH_ASSOC);
if ($query->rowCount())
{
  foreach ($query as $row) {
    $material_list_obj = new Material_List_Info();
    $material_list_obj->id = $row['id'];
    $material_list_obj->branch_id = $row['branch_id'];
    $material_list_obj->material_id = $row['material_id'];
    $material_list_obj->name = $row['name'];
    $material_list_obj->unit_type = $row['unit_type'];
    $material_list_obj->unit_price = $row['unit_price'];
    $material_list_obj->amount = $row['amount'];
    $material_list_obj->quantity = $row['quantity'];
    $material_list_obj->used_quantity = $row['used_quantity'];
    $material_list_obj->is_all_used = $row['is_all_used'];
    $material_list_obj->is_safe_paid = $row['is_safe_paid'];
    $material_list_obj->entry_date = $row['entry_date'];

    $data[] = $material_list_obj;
  }
  echo json_encode($data);
}