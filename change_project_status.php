<?php

/* Proje durumunu değiştir */
include './connection.php';

extract($_POST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.

$query = $db->prepare("UPDATE project SET
is_completed = :is_completed,
total_income = :total_income,
total_expense = :total_expense,
total_gain = :total_gain
WHERE id = :id"); //proje id si

$update = $query->execute(array(
  "is_completed" => $is_completed,
  "total_income" => $total_income,
  "total_expense" => $total_expense,
  "total_gain" => $total_gain,
  "id" => $id
  ));

if ($update)
{
  if ($is_completed == 1)//proje sonlandı değerleri işletmeye hesabına ekle
  {
    $query = $db->prepare("INSERT INTO branch_accounting SET
      branch_id = :branch_id,
      project_id = :project_id,
      type_id = :type_id,
      name = :name,
      amount = :amount
    ");

    $insert = $query->execute(array(
      "branch_id" => "$branch_id",
      "project_id" => "$id", //proje id si
      "type_id" => "$type_id",
      "name" => "$name",
      "amount" => "$total_gain"
    ));
  }
  else if ($is_completed == 0)//tamamlanmış projeyi geri aldıysa sıfır göndermiştir,o zaman bu bilgiyi işletme hesabından da silmemiz gerekiyor
  {
    $query = $db->prepare("DELETE FROM branch_accounting WHERE project_id = :project_id");
    $delete = $query->execute(array(
      'project_id' => $id
    ));
  }

  // print json_encode($_POST);
  print 1;
}