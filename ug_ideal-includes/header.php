<?php 
session_start();
// Показ ошибок
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); ?>
<!-- FONT AWESSOME -->
<script src="https://use.fontawesome.com/e8a42d7e14.js"></script>
<?php
get_header();
// require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
?>
<!-- JQUERY -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- SlickSlider -->
<link rel="stylesheet" 
href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
<link rel="stylesheet" 
href="https://kenwheeler.github.io/slick/slick/slick-theme.css">
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<!-- BOOTSTRAP -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<!-- VUE-JS -->
<?php include_once TEMPLATEPATH.'/ug_ideal-libs/vue-js.php'; ?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/ug_ideal-assets/css/style.css">

<?php include_once 'constants.php'; ?>
