<?php

/* isteden projenin detayını listeler */
include './connection.php';

extract($_REQUEST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.

class Project_Accounting_Info
{

  public $project_accounting_id;
  public $branch_id;
  public $project_id;
  public $type_id;
  public $expense_type_id;
  public $expense_type_name;
  public $material_id;
  public $material_name;
  public $material_quantity;
  // public $project_accounting_name;
  public $purchaser_id;
  public $purchaser_name;
  public $purchaser_surname;
  public $purchaser_firm_name;
  public $unit_sales_price;
  public $quantity;
  public $amount;
  public $description;
  public $is_safe_paid;
  public $entry_date;

}

//$project_id = 3;
//$branch_id = 1;
if ($branch_id == "")
{
  echo json_encode(['Şube id boş olamaz!']);
  exit();
}
else if ($project_id == "")
{
  echo json_encode(['Proje id eksik!']);
  exit();
}

//$column="pa.id,branch_id,project_id,type_id,expense_type_id,material_id,material_quantity";
//$sql = "SELECT * FROM project_accounting AS pa LEFT JOIN material ON material.id=pa.material_id "
/* material isimleri eklenecek */
// $sql = "SELECT * FROM project_accounting AS pa WHERE branch_id=1 AND project_id=3";


$sql = "SELECT  pa.id AS project_accounting_id,pa.branch_id,pa.project_id,pa.type_id,pa.expense_type_id,pa.material_id,pa.material_quantity,
pa.purchaser_id,pa.unit_sales_price,pa.quantity,pa.amount,pa.description,pa.is_safe_paid,pa.entry_date,
m.name AS material_name,
pur.name AS purchaser_name,
pur.surname AS purchaser_surname,
pur.firm_name AS purchaser_firm_name,
et.name AS expense_type_name,
pr.unit_type_id,pa.operation_date 
FROM project_accounting AS pa
LEFT JOIN material AS m ON m.id=pa.material_id
LEFT JOIN project_reap AS pr ON pr.id=pa.project_reap_id
LEFT JOIN purchaser AS pur ON pur.id=pa.purchaser_id
LEFT JOIN expense_type AS et ON et.id=pa.expense_type_id
WHERE pa.branch_id=$branch_id AND pa.project_id=$project_id ORDER BY pa.operation_date DESC";
// echo $sql;
// exit();
// "operation_date" => "$operation_date",

$query = $db->query($sql, PDO::FETCH_ASSOC);

if ($param=='count') {
  echo json_encode($query->rowCount());
  exit();
}
if ($query->rowCount())
{
  foreach ($query as $row) {
    $project_accounting_obj = new Project_Accounting_Info();
    $project_accounting_obj->project_accounting_id = $row['project_accounting_id'];
    $project_accounting_obj->branch_id = $row['branch_id'];
    $project_accounting_obj->project_id = $row['project_id'];
    $project_accounting_obj->type_id = $row['type_id'];
    $project_accounting_obj->expense_type_id = $row['expense_type_id'];
    $project_accounting_obj->expense_type_name = $row['expense_type_name'];
    $project_accounting_obj->material_id = $row['material_id'];
    $project_accounting_obj->material_name = $row['material_name'];
    $project_accounting_obj->unit_type_id = $row['unit_type_id'];
    $project_accounting_obj->material_quantity = $row['material_quantity'];
    // $project_accounting_obj->project_accounting_name = $row['project_accounting_name'];
    $project_accounting_obj->purchaser_id = $row['purchaser_id'];
    $project_accounting_obj->purchaser_name = $row['purchaser_name'];
    $project_accounting_obj->purchaser_surname = $row['purchaser_surname'];
    $project_accounting_obj->purchaser_firm_name = $row['purchaser_firm_name'];
    $project_accounting_obj->unit_sales_price = $row['unit_sales_price'];
    $project_accounting_obj->quantity = $row['quantity'];
    $project_accounting_obj->amount = $row['amount'];
    $project_accounting_obj->description = $row['description'];
    $project_accounting_obj->is_safe_paid = $row['is_safe_paid'];
    $project_accounting_obj->entry_date = $row['entry_date'];
    $project_accounting_obj->operation_date = $row['operation_date'];
    $data[] = $project_accounting_obj;
  }
  echo json_encode($data);
}