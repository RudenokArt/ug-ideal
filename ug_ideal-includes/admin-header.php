<?php 
// Показ ошибок
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>
<?php include_once 'constants.php'; ?>
<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<!-- BOOTSTRAP -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<!-- FONT AWESSOME -->
<script src="https://use.fontawesome.com/e8a42d7e14.js"></script>
<style>
	.smart_number {
  -moz-appearance: textfield;
  -webkit-appearance: textfield;
  appearance: textfield;
}
.smart_number::-webkit-outer-spin-button,
.smart_number::-webkit-inner-spin-button {
  display: none;
}

</style>