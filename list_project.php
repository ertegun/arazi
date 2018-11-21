<?php

/* Projeleri Listeler */
include './connection.php';

extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.

if ($branch_id == "")
{
  extract($_GET);
}

class Project_Info
{

  public $project_id;
  public $branch_id;
  public $type_id;
  public $grower_id;
  public $crop_id;
  public $is_completed;
  public $project_name;
  public $project_field_area;
  public $agreed_amount;
  public $unit_type_id;
  public $qty_per_unit;
  public $quantity;
  public $unit_price;
  public $start_date;
  public $end_date;
  public $duration;
  public $planting_quantity;
  public $expected_quantity;
  public $expected_duration;
  public $expected_end_date;
  public $current_quantity;
  public $total_income;
  public $total_expense;
  public $total_gain;
  public $description;
  public $project_entry_date;
  public $crop_name;
  public $grower_name;
  public $grower_surname;
  public $firm_name;
  public $address;
  public $city_id;
  public $phone_1;
  public $phone_2;
  public $grower_field_area;
  public $grower_entry_date;

}

//$branch_id = 1;
//$is_completed = 1;
if ($branch_id == "")
{
  echo json_encode(['Şube id boş olamaz!']);
  exit();
}
else if ($is_completed == "")
{
  echo json_encode(['Proje tamamlandı mı eksik!']);
  exit();
}

$columnList = 'project.id AS project_id, project.branch_id, type_id, grower_id, crop_id, is_completed, project.name AS project_name,'
  . 'project.field_area AS project_field_area, agreed_amount, unit_type_id, qty_per_unit, quantity, unit_price, start_date, end_date, duration, planting_quantity, expected_quantity,'
  . 'expected_duration, expected_end_date, current_quantity, total_income, total_expense, total_gain, description, project.entry_date AS project_entry_date,'
  . 'crop.name AS crop_name, grower.name AS grower_name,grower.surname AS grower_surname, firm_name, address, city_id,'
  . 'phone_1, phone_2, grower.field_area AS grower_field_area, grower.entry_date AS grower_entry_date';

$sql = "SELECT $columnList FROM project "
  . "INNER JOIN crop ON crop.id=project.crop_id "
  . "LEFT JOIN grower ON grower.id=project.grower_id "
  . "WHERE project.branch_id=$branch_id AND is_completed = $is_completed";

$query = $db->query($sql, PDO::FETCH_ASSOC);

if ($query->rowCount())
{
  foreach ($query as $row) {
    $project_info = new Project_Info();
    $project_info->project_id = $row['project_id'];
    $project_info->branch_id = $row['branch_id'];
    $project_info->type_id = $row['type_id'];
    $project_info->grower_id = $row['grower_id'];
    $project_info->crop_id = $row['crop_id'];
    $project_info->is_completed = $row['is_completed'];
    $project_info->project_name = $row['project_name'];
    $project_info->project_field_area = $row['project_field_area'];
    $project_info->agreed_amount = $row['agreed_amount'];
    $project_info->unit_type_id = $row['unit_type_id'];
    $project_info->qty_per_unit = $row['qty_per_unit'];
    $project_info->quantity = $row['quantity'];
    $project_info->unit_price = $row['unit_price'];
    $project_info->start_date = $row['start_date'];
    $project_info->end_date = $row['end_date'];
    $project_info->duration = $row['duration'];
    $project_info->planting_quantity = $row['planting_quantity'];
    $project_info->expected_quantity = $row['expected_quantity'];
    $project_info->expected_duration = $row['expected_duration'];
    $project_info->expected_end_date = $row['expected_end_date'];
    $project_info->current_quantity = $row['current_quantity'];
    $project_info->total_income = $row['total_income'];
    $project_info->total_expense = $row['total_expense'];
    $project_info->total_gain = $row['total_gain'];
    $project_info->description = $row['description'];
    $project_info->project_entry_date = $row['project_entry_date'];
    $project_info->crop_name = $row['crop_name'];
    $project_info->grower_name = $row['grower_name'];
    $project_info->grower_surname = $row['grower_surname'];
    $project_info->firm_name = $row['firm_name'];
    $project_info->address = $row['address'];
    $project_info->city_id = $row['city_id'];
    $project_info->phone_1 = $row['phone_1'];
    $project_info->phone_2 = $row['phone_2'];
    $project_info->grower_field_area = $row['grower_field_area'];
    $project_info->grower_entry_date = $row['grower_entry_date'];
    $data[] = $project_info;
  }
  echo json_encode($data);
}