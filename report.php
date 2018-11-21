<?php
header('Content-Type: application/json; charset=utf-8');
/* Rapor Çıkarır */
include './connection.php';
extract($_REQUEST);  // POST ile gelen değerleri değişken olarak kullanmamızı sağlar.

class report
{

}

$condition = '';
//operation_date(date_first,date_last),purchaser_name,purchaser_surname,produc_name,grower_name
if ($branch_id != -1) {
  $condition .= " AND b.id=$branch_id ";
}
if ($purchaser_id != -1 && $report_type == 'Purchaser') {
  $condition .= " AND pur.id=$purchaser_id ";
}
if ($product_id != -1) {
  $condition .= " AND c.id=$product_id ";
}
if ($type_id != -1) {
  $condition .= " AND pt.id=$type_id ";
}
if ($grower_id != -1 && $report_type == 'Grower') {
  $condition .= " AND g.id='$grower_id' ";
}
if ($date_first != -1 && $date_last != -1) {
//  $condition .= " AND pa.operation_date BETWEEN '$date_first' AND '$date_last' ";
}


if ($report_type == 'Purchaser') {
  $condition = " AND pur.id=$purchaser_id ";

  $sql = "SELECT pur.name AS pur_name,pur.surname AS pur_surname,c.name AS c_name, pa.operation_date, pa.satilan_birim_fiyat AS pa_unit_sales_price,
pa.satilan_miktar AS pa_quantity,pa.odenen_para AS pa_amount, pa.satilan_birim AS pr_unit_type_id
FROM purchaser_accounting pa
LEFT JOIN crop AS c ON c.id=pa.crop_id
LEFT JOIN project_reap AS pr ON pr.project_id=pa.id
LEFT JOIN purchaser AS pur ON pur.id=pa.purchaser_id
WHERE 1=1 $condition ORDER BY pa.id";
  // echo $sql;
  // exit;

  $query = $db->query($sql, PDO::FETCH_ASSOC);
  $data = array();
  if ($query->rowCount()) {
    $proje_id_arr = array();

    foreach ($query as $row) {
      $report_obj = new report();
      $report_obj->purchaser_name = null;
      $report_obj->grower_name = null;
      if ($report_type == 'Grower') {
        $report_obj->grower_name = $row['g_name'] . ' ' . $row['g_surname'];
      } else if ($report_type == 'Purchaser') {
        $report_obj->purchaser_name = $row['pur_name'] . ' ' . $row['pur_surname'];
      }

      $report_obj->product_name = $row['c_name'];
      $report_obj->project_type = $row['pt_name'];
      $report_obj->unit_type_id = $row['pr_unit_type_id'];
      $report_obj->description = $row['pa_description'];
      $report_obj->amount = $row['pa_amount'];
      $report_obj->unit_sales_price = $row['pa_unit_sales_price'];
      $report_obj->quantity = $row['pa_quantity'];
      $report_obj->expense_type_id = $row['pa_expense_type_id'];
      $report_obj->project_id = $row['p_id'];

      if (!in_array($row['p_id'], $proje_id_arr)) {
        // $report_obj->agreed_amount += $row['p_agreed_amount']*1;
        array_push($proje_id_arr, $row['p_id']);
      }

      $report_obj->agreed_amount = $row['p_agreed_amount'] * 1;
      $report_obj->operation_date = $row['operation_date'];
      // $report_obj->sql = $sql;
      $data[] = $report_obj;
    }
  }
} else if ($report_type == 'Grower_oldasdas') {
  /* Çiftçiye Olan Borç */
  $sql = "SELECT g.name AS g_name,g.surname AS g_surname,
c.name AS c_name , pt.name AS pt_name,
p.agreed_amount AS p_agreed_amount,p.id AS p_id, p.agreed_amount, p.start_date
FROM project AS p
LEFT JOIN branch AS b ON b.id=p.branch_id
LEFT JOIN project_type AS pt ON pt.id=p.type_id
LEFT JOIN grower AS g ON g.id=p.grower_id
LEFT JOIN crop AS c ON c.id=p.crop_id
WHERE 1=1 $condition  ORDER BY p.id";

  $query = $db->query($sql, PDO::FETCH_ASSOC);
  $data_borc = array();
  if ($query->rowCount()) {
    $proje_id_arr = array();

    foreach ($query as $row) {
      $report_obj = new report();
      $report_obj->purchaser_name = null;
      $report_obj->grower_name = null;
      $report_obj->grower_name = $row['g_name'] . ' ' . $row['g_surname'];
      $report_obj->product_name = $row['c_name'];
      $report_obj->project_type = $row['pt_name'];
      $report_obj->unit_type_id = $row['pr_unit_type_id'];
      $report_obj->description = '';
      $report_obj->amount = 0;
      $report_obj->unit_sales_price = $row['pa_unit_sales_price'];
      $report_obj->quantity = $row['pa_quantity'];
      $report_obj->expense_type_id = $row['pa_expense_type_id'];
      $report_obj->project_id = $row['p_id'];

      if (!in_array($row['p_id'], $proje_id_arr)) {
        // $report_obj->agreed_amount += $row['p_agreed_amount']*1;
        array_push($proje_id_arr, $row['p_id']);
      }
      $agreed_amount = $row['p_agreed_amount'] * 1;
      $report_obj->agreed_amount = $agreed_amount;
      $report_obj->operation_date = $row['start_date'];
//      $report_obj->sql = $sql;

      $data_borc[] = $report_obj;
    }
  }
  /* Çiftçiye Olan Borç */
  /* Çiftçiye Ödenen Para */

  $sql = "SELECT g.name AS g_name,g.surname AS g_surname,
c.name AS c_name , pt.name AS pt_name,
p.agreed_amount AS p_agreed_amount,p.id AS p_id, p.agreed_amount, p.start_date,pa.amount AS p_amount, pa.description AS pa_description
FROM project AS p
LEFT JOIN branch AS b ON b.id=p.branch_id
LEFT JOIN project_type AS pt ON pt.id=p.type_id
LEFT JOIN grower AS g ON g.id=p.grower_id
LEFT JOIN crop AS c ON c.id=p.crop_id
LEFT JOIN project_accounting AS pa ON pa.project_id=p.id
WHERE 1=1 $condition AND pa.amount<0 AND pa.expense_type_id=2  ORDER BY p.id";
//  echo $sql;
//  exit;
  $query = $db->query($sql, PDO::FETCH_ASSOC);
  $data_odenen = array();
  if ($query->rowCount()) {
    $proje_id_arr = array();

    foreach ($query as $row) {
      $report_obj = new report();
      $report_obj->purchaser_name = null;
      $report_obj->grower_name = null;
      $report_obj->grower_name = $row['g_name'] . ' ' . $row['g_surname'];
      $report_obj->product_name = $row['c_name'];
      $report_obj->project_type = $row['pt_name'];
      $report_obj->unit_type_id = $row['pr_unit_type_id'];
      $report_obj->description = $row['pa_description'];
      $report_obj->amount = $row['pa_amount'];
      $report_obj->unit_sales_price = $row['pa_unit_sales_price'];
      $report_obj->quantity = $row['pa_quantity'];
      $report_obj->expense_type_id = $row['pa_expense_type_id'];
      $report_obj->project_id = $row['p_id'];

      if (!in_array($row['p_id'], $proje_id_arr)) {
        // $report_obj->agreed_amount += $row['p_agreed_amount']*1;
        array_push($proje_id_arr, $row['p_id']);
      }
      $report_obj->agreed_amount = 0;
      $report_obj->operation_date = $row['start_date'];
      $report_obj->amount = $row['p_amount'];


      $data_odenen[] = $report_obj;
    }
  }
  /* Çiftçiye Ödenen Para */

  $data = array_merge($data_borc, $data_odenen);

  echo json_encode($data);
  exit;
} else if ($report_type == 'Goturu') {
  $condition = '';
  if ($product_id != -1) {
    $condition .= " AND c.id=$product_id ";
  }
  $sql = "SELECT p.id proje_id,p.type_id AS proje_tipi, p.unit_type_id AS birim, CONCAT( g.name,' ',g.surname) AS grower_name ,p.entry_date,
    p.expected_quantity AS anlasilan_miktar,p.planting_quantity AS anlasilan_miktar_kasa_hesabi,
p.agreed_amount AS anlasma_bedeli,pa.amount AS kazanilan_para,pa.quantity AS satilan_miktar , c.name AS product_name,pa.expense_type_id AS pa_expense_type_id
FROM project AS p
LEFT JOIN branch AS b ON b.id=p.branch_id
LEFT JOIN project_type AS pt ON pt.id=p.type_id
LEFT JOIN grower AS g ON g.id=p.grower_id
LEFT JOIN crop AS c ON c.id=p.crop_id
LEFT JOIN project_accounting pa ON pa.project_id=p.id
WHERE 1=1
AND b.id=1
$condition
AND g.id=$grower_id
 ORDER BY p.id";

//  echo $sql;
//  exit;
  $query = $db->query($sql, PDO::FETCH_ASSOC);
  $data_odenen = array();
  if ($query->rowCount()) {
    $proje_id_arr = array();

    foreach ($query as $row) {
      $report_obj = new report();
      $report_obj->purchaser_name = null;
      $report_obj->grower_name = $row['grower_name'];
      $report_obj->project_id = $row['proje_id'];
//      $report_obj->entry_date = $row['entry_date'];
      $report_obj->product_name = $row['product_name'];
      $anlasilan_miktar = $row['anlasilan_miktar'];

      if ($row['proje_tipi'] == 2)//2->kasa hesabı
      {
        $anlasilan_miktar = $row['anlasilan_miktar_kasa_hesabi'];
      }
      $report_obj->anlasilan_miktar = $anlasilan_miktar;
      $report_obj->unit_type_id = $row['birim'];
      $report_obj->anlasma_bedeli = $row['anlasma_bedeli'];

      $report_obj->kazanilan_para = ($row['kazanilan_para'] == null) ? 0 : $row['kazanilan_para'];
      $report_obj->satilan_miktar = ($row['satilan_miktar'] == null) ? 0 : $row['satilan_miktar'];
      $report_obj->expense_type_id = ($row['pa_expense_type_id'] == null) ? 0 : $row['pa_expense_type_id'];
//      if (!in_array($row['p_id'], $proje_id_arr))
//      {
//        // $report_obj->agreed_amount += $row['p_agreed_amount']*1;
//        array_push($proje_id_arr, $row['p_id']);
//      }
      $report_obj->agreed_amount = 0;
      $report_obj->operation_date = $row['entry_date'];
      $report_obj->amount = $row['p_amount'];


      $data[] = $report_obj;
    }
  }
} else if ($report_type == 'Grower') {
  $sql_borc = "SELECT
  CONCAT(g.name, ' ', g.surname) AS grower_name,
  c.name AS product_name,
  ga.alacak_verecek AS alacak_verecek,
  p.unit_type_id,
  p.planting_quantity AS quantity
FROM
  grower_accounting ga
  LEFT JOIN grower AS g
    ON g.id = ga.grower_id
  LEFT JOIN project p
    ON p.id = ga.project_id
  LEFT JOIN crop c
    ON c.id = p.crop_id ";
  $query = $db->query($sql_borc, PDO::FETCH_ASSOC);
  $data_borc = array();
  if ($query->rowCount()) {
    $proje_id_arr = array();

    foreach ($query as $row) {
      $report_obj = new report();
      $report_obj->grower_name = $row['grower_name'];
      $report_obj->product_name = $row['product_name'];
      $report_obj->alacak_verecek = $row['alacak_verecek'] * 1;

//      $report_obj->
//      $report_obj->sql = $sql;

      $data_borc[] = $report_obj;
    }
  }

  echo json_encode($data_borc);
//  echo $sql_borc;
  exit;
}

echo json_encode($data);

