<?php

try {
  $db = new PDO("mysql:host=localhost;dbname=grower_app_db;charset=utf8", "mrrobot", "mrrobot");
//  $db = new PDO("mysql:host=localhost;dbname=u975746063_arazi;charset=utf8", "u975746063_uaraz", "acer123ert");
} catch (PDOException $e) {
  print $e->getMessage();
}

