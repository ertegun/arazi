<?php 
include './connection.php';
extract($_POST);

$prm = array(
  'branch_id' => $branch_id,
  'id' => $project_id
);

$query = $db->prepare("DELETE FROM project WHERE branch_id=:branch_id AND id=:id");
$query->execute($prm);

if ($query->rowCount()) {

  $sql = "SELECT material_id,material_quantity FROM project_accounting WHERE branch_id=$branch_id AND project_id=$project_id";
  $query_ = $db->query($sql, PDO::FETCH_ASSOC);

  if ($query_->rowCount()) {
    foreach ($query_ as $row) {
      $material_id = $row['material_id'];
      $material_quantity = $row['material_quantity'];
      $sql = "UPDATE material_stock SET used_quantity=used_quantity-$material_quantity WHERE id=$material_id";
      $stmt = $db->prepare($sql);
      $stmt->execute();
    }
  }

  $query = $db->prepare("DELETE FROM project_accounting WHERE branch_id=:branch_id AND project_id=:id");
  $query->execute($prm);

  $query = $db->prepare("DELETE FROM purchaser_accounting WHERE branch_id=:branch_id AND project_id=:id");
  $query->execute($prm);

  $query = $db->prepare("DELETE FROM grower_accounting WHERE branch_id=:branch_id AND project_id=:id");
  $query->execute($prm);

  $query = $db->prepare("DELETE FROM branch_accounting WHERE branch_id=:branch_id AND project_id=:id");
  $query->execute($prm);

  $query = $db->prepare("DELETE FROM project_reap WHERE branch_id=:branch_id AND project_id=:id");
  $query->execute($prm);

  print 1;

}




