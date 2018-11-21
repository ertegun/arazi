<?php

/* kullanımda değil */
include './connection.php';

extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.

class Branch_Accounting_Info
{

  public $id;
  public $branch_id;
  public $project_id;
  public $type_id;
  public $branch_accounting_name;
  public $project_name;
  public $amount;
  public $operation_date;
  public $description;
  public $entry_date;

}

$sql = "SELECT ba.id,ba.branch_id,ba.project_id,ba.type_id,ba.name AS branch_accounting_name,ba.amount,ba.description,ba.entry_date,
p.is_completed,p.name AS project_name,ba.operation_date
FROM branch_accounting AS ba
LEFT JOIN project AS p ON p.id=ba.project_id
WHERE ba.branch_id = $branch_id AND ba.operation_date BETWEEN '$date_first' AND '$date_last' ORDER BY ba.operation_date DESC";

$query = $db->query($sql, PDO::FETCH_ASSOC);

if ($query->rowCount())
{
  foreach ($query as $row) {
    $branch_accounting_obj = new Branch_Accounting_Info();
    $branch_accounting_obj->id = $row['id'];
    $branch_accounting_obj->branch_id = $row['branch_id'];
    $branch_accounting_obj->project_id = $row['project_id'];
    $branch_accounting_obj->type_id = $row['type_id'];
    $branch_accounting_obj->branch_accounting_name = $row['branch_accounting_name'];
    $branch_accounting_obj->project_name = $row['project_name'];
    $branch_accounting_obj->amount = $row['amount'];
    $branch_accounting_obj->operation_date = $row['operation_date'];
    $branch_accounting_obj->description = $row['description'];
    $branch_accounting_obj->entry_date = $row['entry_date'];

    $data[] = $branch_accounting_obj;
  }
  echo json_encode($data);
}