<?php
/*
Template Name: ug_ideal-wallpaper
*/

$GLOBALS['admin_current_gallery'] = 'wallpaper';
include_once 'ug_ideal-includes/header.php';

if (isset($_GET['id'])) {
	include_once 'ug_ideal-includes/wallpaper-detail-view.php';
} else {
	include_once 'ug_ideal-includes/modular-gallery-view.php';
}

get_footer(); 
?>