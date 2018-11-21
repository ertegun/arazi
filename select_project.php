<?php

/* İşletmedeki projeleri listeler (işletme id ve tamamlanmış yada tamamlanmamış) */
include './connection.php';

extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.

class Project_Info
{

  public $id;
  public $name;

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

$sql = "SELECT id,name FROM project WHERE branch_id=$branch_id AND is_completed =$is_completed";

$query = $db->query($sql, PDO::FETCH_ASSOC);

if ($query->rowCount())
{
  foreach ($query as $row) {
    $project_info = new Project_Info();
    $project_info->id = $row['id'];
    $project_info->name = $row['name'];
    $data[] = $project_info;
  }
  echo json_encode($data);
}