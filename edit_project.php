<?php

include './connection.php';
extract($_POST); 
$dataArr=array();
if ($type_id==2) {//kasa hesabı
  $query = $db->prepare("UPDATE project SET
  crop_id=:crop_id,branch_id=:branch_id,grower_id=:grower_id,start_date=:start_date,description=:description 
  WHERE id = :id");
  $dataArr = array(
    "id" => $project_id,
    "branch_id" => $branch_id,    
    "crop_id" => $crop_id,
    "grower_id" => $grower_id,
    "start_date" => $start_date,
    // "agreed_amount" => $agreed_amount,
    "description" => $description
  );
  
}else if ($type_id==1) {//götürü
  $query = $db->prepare("UPDATE project SET
  crop_id=:crop_id,branch_id=:branch_id,grower_id=:grower_id,start_date=:start_date,planting_quantity=:planting_quantity,
  earnest_money=:earnest_money,agreed_amount=:agreed_amount,description=:description 
  WHERE id = :id");
  $dataArr = array(
    "id" => $project_id,
    "branch_id" => $branch_id,    
    "crop_id" => $crop_id,
    "grower_id" => $grower_id,
    "start_date" => $start_date,
    "planting_quantity" => $planting_quantity,
    "earnest_money" => $earnest_money,
    "agreed_amount" => $agreed_amount,    
    "description" => $description
  );
}else if ($type_id==0) {//iç arazi
  $query = $db->prepare("UPDATE project SET
  crop_id=:crop_id,branch_id=:branch_id,grower_id=:grower_id,start_date=:start_date,description=:description 
  WHERE id = :id");
   $dataArr = array(
    "id" => $project_id,
    "branch_id" => $branch_id,    
    "crop_id" => $crop_id,
    "grower_id" => $grower_id,
    "start_date" => $start_date,
    "description" => $description
  );
}

$update = $query->execute($dataArr);

// $result['query']=$dataArr;
// $result['asd']=123;

if ( $update ){
  // $result['result']=1;
  print 1;
}

// echo json_encode( $update );
