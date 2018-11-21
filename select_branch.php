<?php

/* Çiftçi listesini listele */
include './connection.php';

extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.
//$branch_id = 1;


$query = $db->query("SELECT name FROM branch WHERE id = $branch_id", PDO::FETCH_ASSOC);

if ($query->rowCount())
{
  foreach ($query as $row) {
    echo $row['name'];
  }
}