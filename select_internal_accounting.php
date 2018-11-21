<?php

/* Kullanımda değil */
include './connection.php';

//extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.
class Internal_Accounting_Info
{

  public $id;
  public $project_id;
  public $type_id;
  public $name;
  public $process_date;
  public $purchaser_id;
  public $unit_sales_price;
  public $quantity;
  public $amount;
  public $description;
  public $entry_date;

}

$query = $db->query("SELECT * FROM internal_field_accounting", PDO::FETCH_ASSOC);
if ($query->rowCount())
{
  foreach ($query as $row) {
    $internal_accounting_obj = new Internal_Accounting_Info();
    $internal_accounting_obj->id = $row['id'];
    $internal_accounting_obj->project_id = $row['project_id'];
    $internal_accounting_obj->type_id = $row['type_id'];
    $internal_accounting_obj->name = $row['name'];
    $internal_accounting_obj->process_date = $row['process_date'];
    $internal_accounting_obj->purchaser_id = $row['purchaser_id'];
    $internal_accounting_obj->unit_sales_price = $row['unit_sales_price'];
    $internal_accounting_obj->quantity = $row['quantity'];
    $internal_accounting_obj->amount = $row['amount'];
    $internal_accounting_obj->description = $row['description'];
    $internal_accounting_obj->entry_date = $row['entry_date'];

    $data[] = $internal_accounting_obj;
  }
  echo json_encode($data);
}