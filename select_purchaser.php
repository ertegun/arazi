<?php

/* ürünü satın alacak kişileri listeler */
include './connection.php';

extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.

class Purchaser_Info
{

  public $id;
  public $name;
  public $surname;
  public $firm_name;
  public $address;
  public $city_id;
  public $phone1;
  public $phone2;

}

$query = $db->query("SELECT * FROM purchaser WHERE branch_id = $branch_id", PDO::FETCH_ASSOC);

if ($query->rowCount())
{
  foreach ($query as $row) {
    $purchaser_info = new Purchaser_Info();
    $purchaser_info->id = $row['id'];
    $purchaser_info->name = $row['name'];
    $purchaser_info->surname = $row['surname'];
    $purchaser_info->firm_name = $row['firm_name'];
    $purchaser_info->address = $row['address'];
    $purchaser_info->city_id = $row['city_id'];
    $purchaser_info->phone1 = $row['phone1'];
    $purchaser_info->phone2 = $row['phone2'];
    $data[] = $purchaser_info;
  }

  echo json_encode($data);
}