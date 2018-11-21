<?php 
include './connection.php';
extract($_POST); 

$query = $db->prepare("DELETE FROM branch_accounting 
WHERE branch_id = :branch_id AND id = :id");
$delete = $query->execute(array(
   'branch_id' => $branch_id,
   'id' => $branch_accounting_id,
));
$count = $query->rowCount();
print $count*1;