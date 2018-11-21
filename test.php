<?php

include './connection.php';

$query = $db->prepare("DELETE FROM branch_accounting WHERE project_id = :project_id");
$delete = $query->execute(array(
  'project_id' => 3
  ));
