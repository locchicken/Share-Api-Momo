<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
$min  = $_POST['min'];
$max = $_POST['max'];
$noidung = $_POST['noidung'];
if ($min != "" && $max  != "" && $noidung  != "") {
  $sql = hoangphuc("UPDATE `caidat_momo` SET toithieu = '$min', toida = '$max', noidung = '$noidung' WHERE id= 1");
  echo 1;
} else {
  echo 0;
  exit();
}
