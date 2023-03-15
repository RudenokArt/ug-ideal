<?php
/*
Template Name: ug_ideal-modular
*/

include_once 'ug_ideal-includes/header.php';

if (isset($_GET['edit'])) {
	include_once 'ug_ideal-includes/modular-detail-edit.php';
} elseif (isset($_GET['id'])) {
	include_once 'ug_ideal-includes/modular-detail-view.php';
} else {
	include_once 'ug_ideal-includes/modular-gallery-view.php';
}

get_footer(); 
?>

