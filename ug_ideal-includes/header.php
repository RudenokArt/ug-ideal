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

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/ug_ideal-assets/css/style.css?v=<?php echo time(); ?>">

<?php 
include_once 'constants.php';
include_once $theme_path.'/ug_ideal-libs/dompdf/Company_data.php';
$GLOBALS['company_contacts'] = new Company_data();

$main_menu = wp_get_nav_menus(['name'=>'Основное меню'])[0];
$main_menu_arr = wp_get_nav_menu_items($main_menu->term_id);
?>

<div class="header pt-3 pb-3" style="background: #3cb2e4;">
	<div class="container">
		<div class="row align-items-center">

			<a href="/" class="col-lg-2 col-md-3 col-sm-4 col-4">
				<img src="<?php echo $theme_url.'/ug_ideal-libs/dompdf/img/ug-ideal.png?='.time(); ?>" class="w-100">
			</a>

			<div class="col-lg-6 col-md-6 d-lg-block d-md-block d-sm-none d-none h4 text-light">
				<div><?php echo $GLOBALS['company_contacts']->company_name; ?></div>
			</div>

			<div class="col-lg-1 col-md-1 col-sm-2 col-2 h4 text-light">
				<div class="header-drop_menu-wrapper">
					<i class="fa fa-envelope-o" aria-hidden="true"></i>
					<div class="header-drop_menu" style="right: -150px;">
						<?php foreach ($GLOBALS['company_contacts']->company_email as $key => $value): ?>
							<a href="tel:<?php echo $value;?>" class="header-drop_menu-item h5 d-block p-2 m-0">
								<?php echo $value; ?>
							</a>
						<?php endforeach ?>
					</div>
				</div>				
			</div>
			<div class="col-lg-1 col-md-1 col-sm-2 col-2 h6 text-light">
				<div class="header-drop_menu-wrapper">
					<i class="fa fa-phone" aria-hidden="true"></i>
					<div class="header-drop_menu" style="right: -100px;">
						<?php foreach ($GLOBALS['company_contacts']->company_phones as $key => $value): ?>
							<a href="tel:<?php echo $value;?>" class="header-drop_menu-item h5 d-block p-2 m-0">
								<?php echo $value; ?>
							</a>
						<?php endforeach ?>
						<div class="text-info p-3">
							<i class="fa fa-clock-o" aria-hidden="true"></i>
							<?php echo $GLOBALS['company_contacts']->work_time; ?>
						</div>
					</div>
				</div>				
			</div>
			<div class="col-lg-1 col-md-1 col-sm-2 col-2 h4 text-light">
				<div class="header-drop_menu-wrapper">
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					<div class="header-drop_menu h6" style="right: -50px;">
						<?php foreach ($GLOBALS['company_contacts']->company_address as $key => $value): ?>
							<a href="/contacts/" class="header-drop_menu-item d-block p-2 m-0">
								<?php echo $value; ?>
							</a>
						<?php endforeach ?>
						<div class="text-info p-3">
							<i class="fa fa-clock-o" aria-hidden="true"></i>
							<?php echo $GLOBALS['company_contacts']->work_time; ?>
						</div>
					</div>
				</div>				
			</div>
			<div class="col-lg-1 col-md-1 col-sm-2 col-2 h1 text-light">
				<div class="header-drop_menu-wrapper">
					<i class="fa fa-bars" aria-hidden="true"></i>
					<div class="header-drop_menu">
						<div class="header-drop_menu-social_networks text-center p-3">
							<?php foreach ($GLOBALS['company_contacts']->social_networks as $key => $value): ?>
								<?php if ($value): ?>
									<a href="<?php echo $value; ?>" class="header-social_networks-item h5 p-2">
										<i class="fa fa-<?php echo $key;?>" aria-hidden="true"></i>
									</a>
								<?php endif ?>
							<?php endforeach ?>
						</div>
						<div class="p2">
							<?php foreach ($main_menu_arr as $key => $value): ?>
								<a href="<?php echo $value->url; ?>" class="p-2 d-block h5 header-main_menu-item">
									<?php echo $value->title; ?>
								</a>
							<?php endforeach ?>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>

<?php if (isset($_POST['footer_feedback_form'])) {
	$footer_feedback_form = (mail(
		'zakaz@ug-ideal.ru',
		'Сообщение с формы обратной связи на сайте',
		'ФИО: '.$_POST['user_name'].'; '.
		'Email: '.$_POST['user_email'].'; '.
		'Текст сообщения: '.$_POST['user_message']
	));
} ?>

<?php if ($footer_feedback_form): ?>
	<div class="container pt-5">
		<div class="alert alert-success text-center">
			Сообщение отправлено.
		</div>
	</div>	
<?php endif ?>
