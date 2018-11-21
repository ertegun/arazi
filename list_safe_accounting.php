<?php

/* Kullanımda değil */
include './connection.php';

class Branc_Safe_Info
{

  public $id;
  public $branch_id;
  public $purchaser_id;
  public $type_id;
  public $project_id;
  public $expense_type_id;
  public $name;
  public $amount;
  public $description;

}

$query = $db->query("SELECT * FROM safe_accounting", PDO::FETCH_ASSOC);

if ($query->rowCount())
{
  foreach ($query as $row) {
    $branch_safe_info = new Branc_Safe_Info();
    $branch_safe_info->id = $row['id'];
    $branch_safe_info->branch_id = $row['branch_id'];
    $branch_safe_info->purchaser_id = $row['purchaser_id'];
    $branch_safe_info->type_id = $row['type_id'];
    $branch_safe_info->project_id = $row['project_id'];
    $branch_safe_info->expense_type_id = $row['expense_type_id'];
    $branch_safe_info->name = $row['name'];
    $branch_safe_info->amount = $row['amount'];
    $branch_safe_info->description = $row['description'];
    $data[] = $branch_safe_info;
  }
}
echo json_encode($data);

