<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
$tieude  = $_POST['tieude'];
$website = $_POST['website'];
$mota = $_POST['mota'];
$tukhoa = $_POST['tukhoa'];
$image = $_POST['image'];
$email = $_POST['email'];
$sdt   = $_POST['sdt'];
$chietkhau = $_POST['chietkhau'];
if ($tieude != "" && $website != "" && $mota  != "" && $tukhoa  != "" && $image  != "" && $email  != "" && $chietkhau != "" && $sdt != "") {
  $sql = hoangphuc("UPDATE `caidat` SET tieude = '$tieude', website = '$website', mota = '$mota', tukhoa = '$tukhoa', image = '$image', email = '$email', sdt = '$sdt', chietkhau = '$chietkhau' WHERE id = 1");
  echo 1;
} else {
  echo 0;
  exit();
}
