<?php

/* Çiftçi listesini listele */
include './connection.php';

extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.
//$branch_id = 1;

class Grower_Info
{

  public $id;
  public $name;
  public $surname;
  public $firm_name;
  public $address;
  public $city_id;
  public $phone_1;
  public $phone_2;
  public $field_area;
  public $entry_date;

}

$query = $db->query("SELECT * FROM grower WHERE branch_id = $branch_id", PDO::FETCH_ASSOC);

if ($query->rowCount())
{
  foreach ($query as $row) {
    $grow_info = new Grower_Info();
    $grow_info->id = $row['id'];
    $grow_info->name = $row['name'];
    $grow_info->surname = $row['surname'];
    $grow_info->firm_name = $row['firm_name'];
    $grow_info->address = $row['address'];
    $grow_info->city_id = $row['city_id'];
    $grow_info->phone_1 = $row['phone_1'];
    $grow_info->phone_2 = $row['phone_2'];
    $grow_info->field_area = $row['field_area'];
    $grow_info->entry_date = $row['entry_date'];
    $data[] = $grow_info;
  }

  echo json_encode($data);
}