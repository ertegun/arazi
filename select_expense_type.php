<?php

/* Gider türlerini listele */
include './connection.php';

class Expense_Type_Info
{

  public $id;
  public $name;

}

$query = $db->query("SELECT * FROM expense_type", PDO::FETCH_ASSOC);
if ($query->rowCount())
{
  foreach ($query as $row) {
    $expense_info = new Expense_Type_Info();
    $expense_info->id = $row['id'];
    $expense_info->name = $row['name'];
    $data[] = $expense_info;
  }
}
echo json_encode($data);

