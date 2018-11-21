<?php

include './connection.php';
extract($_POST);
$query = $db->prepare("DELETE FROM material_stock WHERE id=:id");
$delete = $query->execute(array(
  'id' => $id,
  ));

if ($query->rowCount())
{
  print 1;
}
// json_encode( $count, JSON_UNESCAPED_UNICODE );
