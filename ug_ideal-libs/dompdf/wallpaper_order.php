<?php 

$html = file_get_contents('wallpaper_order-template.php');
$html = wallpaperOrderVarsInsert($html);
$file_output = 'wallpaper_order.pdf';
include_once 'index.php';
print_r($_GET);


function wallpaperOrderVarsInsert ($html) {
  if ($_GET['imageName']) {
    $html = str_replace('imageName', $_GET['imageName'], $html);
  }

  if ($_GET['texture']) {
    $html = str_replace('texture', $_GET['texture'], $html);
  }

  if ($_GET['wallX']) {
    $html = str_replace('wallX', $_GET['wallX'], $html);
  }
  if ($_GET['wallY']) {
    $html = str_replace('wallY', $_GET['wallY'], $html);
  }
  if ($_GET['roll']) {
    $html = str_replace('roll', $_GET['roll'], $html);
  }

  if ($_GET['amount']) {
    $html = str_replace('amount', $_GET['amount'], $html);
  } else {
    $html = str_replace('amount', '', $html);
  }
  if ($_GET['discount']) {
    $html = str_replace('discount', $_GET['discount'].'%', $html);
  } else {
    $html = str_replace('discount', '', $html);
  }
  if ($_GET['total']) {
    $html = str_replace('total', $_GET['total'], $html);
  } else {
    $html = str_replace('total', '', $html);
  }
  if ($_GET['customer_mail']) {
    $html = str_replace('customer_mail', $_GET['customer_mail'], $html);
  } else {
    $html = str_replace('customer_mail', '', $html);
  }
  if ($_GET['customer_fio']) {
    $html = str_replace('customer_fio', $_GET['customer_fio'], $html);
  } else {
    $html = str_replace('customer_fio', '', $html);
  }
  if ($_GET['customer_phone']) {
    $html = str_replace('customer_phone', $_GET['customer_phone'], $html);
  } else {
    $html = str_replace('customer_phone', '', $html);
  }
  return $html;
}


?>