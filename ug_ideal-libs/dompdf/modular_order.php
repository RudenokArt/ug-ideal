<?php 

$html = file_get_contents('modular_order-template.php');
$html = htmlVariablesInsert($html);
$file_output = 'modular_order.pdf';
include_once 'index.php';

function htmlVariablesInsert ($html) {
  if ($_GET['imageName']) {
    $html = str_replace('imageName', $_GET['imageName'], $html);
  }
  if ($_GET['material']) {
    $html = str_replace('material', $_GET['material'], $html);
  }
  if ($_GET['size']) {
    $html = str_replace('size', $_GET['size'], $html);
  } else {
    $html = str_replace('size', '', $html);
  }
  if ($_GET['amount']) {
    $html = str_replace('amount', $_GET['amount'], $html);
  } else {
    $html = str_replace('amount', '', $html);
  }
  if ($_GET['discount']) {
    $html = str_replace('discount', $_GET['discount'], $html);
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