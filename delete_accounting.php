<?php 
include './connection.php';
extract($_POST);


$sql = "SELECT id,material_id,material_quantity,project_reap_id FROM project_accounting WHERE id=$project_accounting_id";
$query_ = $db->query($sql, PDO::FETCH_ASSOC);

if ($query_->rowCount()) {
  foreach ($query_ as $row) {
    $material_id = $row['material_id'];
    $project_reap_id = $row['project_reap_id'];

    $material_quantity = $row['material_quantity'];
    if ($material_quantity > 0) {
      $sql = "UPDATE material_stock SET used_quantity=used_quantity-$material_quantity WHERE id=$material_id";
      $stmt = $db->prepare($sql);
      $stmt->execute();
    }

    $prm = array(
      'project_accounting_id' => $project_accounting_id
    );
    $query = $db->prepare("DELETE FROM purchaser_accounting WHERE  project_accounting_id=:project_accounting_id");
    $query->execute($prm);

    $query = $db->prepare("DELETE FROM grower_accounting WHERE  project_accounting_id=:project_accounting_id");
    $query->execute($prm);

    $query = $db->prepare("DELETE FROM project_reap WHERE  id=:id");
    $query->execute(array('id' => $project_reap_id));
  }
}



$query = $db->prepare("DELETE FROM project_accounting WHERE branch_id = :branch_id AND id = :id");
$delete = $query->execute(array(
  'branch_id' => $branch_id,
  'id' => $project_accounting_id,
));
$count = $query->rowCount();
print $count * 1;