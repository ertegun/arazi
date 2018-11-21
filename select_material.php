<?php

/* Malzeme listesi */
include './connection.php';

class Material_Info
{

  public $id;
  public $name;

}

$query = $db->query("SELECT * FROM material", PDO::FETCH_ASSOC);

if ($query->rowCount())
{
  foreach ($query as $row) {
    $material_info = new Material_Info();
    $material_info->id = $row['id'];
    $material_info->name = $row['name'];
    $data[] = $material_info;
  }

  echo json_encode($data);
}