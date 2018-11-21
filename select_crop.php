<?php

/* Ürünleri listele */
include './connection.php';

class Crop_Info
{

  public $id;
  public $name;

}

$query = $db->query("SELECT * FROM crop", PDO::FETCH_ASSOC);
if ($query->rowCount())
{
  foreach ($query as $row) {
    $crop_info = new Crop_Info();
    $crop_info->id = $row['id'];
    $crop_info->name = $row['name'];
    $data[] = $crop_info;
  }
}
echo json_encode($data);

