<?php 

/*
Template Name: ug_ideal-contacts
*/

$maps_yandex_arr = [
	'',

	'<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A15f410260bf8262eb46fff9ca90e2456efd907b95b4ff1be34622b13000b4079&amp;width=500&amp;height=300&amp;lang=ru_RU&amp;scroll=true"></script>',

	'<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Acea8a7621a8f6017fe1b26f31363de6ef4622055efac2777f1972b59fcbf2538&amp;width=500&amp;height=300&amp;lang=ru_RU&amp;scroll=true"></script>',


	'<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A7be626d92e2f9127908ffea6fce4c0542971935a75891150aab86a18bb97ecdc&amp;width=500&amp;height=300&amp;lang=ru_RU&amp;scroll=true"></script>',
];

?>
<?php include_once 'ug_ideal-includes/header.php'; ?>
<div class="container pt-3 pb-3 mt-5">
	<div class="row">
		<?php foreach ($GLOBALS['company_contacts']->company_address as $key => $value): ?>
			<div class="pb-5 col-lg-6 col-md-12 col-sm-12 col-12">
				<div class="h4">
					<?php echo $GLOBALS['company_contacts']->company_name; ?>
				</div>
				<div class="h5"><?php echo $value->post_title; ?></div>
				<?php if ($value->post_content): ?>
					<?php echo $value->post_content; ?>
				<?php else: ?>
							<div class="col-lg-6 col-md-12 col-sm-12 col-12">
			<?php foreach ($GLOBALS['company_contacts']->company_phones as $key => $value): ?>
				<a href="tel:<?php echo $value; ?>" class="d-block pt-1 footer-phone">
					<svg  width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
						<path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
					</svg>
					<?php echo $value; ?>
				</a>
			<?php endforeach ?>
			<?php foreach ($GLOBALS['company_contacts']->company_email as $key => $value): ?>
				<a href="mailto:<?php echo $value; ?>" class="d-block pt-1 footer-email">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
						<path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
					</svg>
					<?php echo $value; ?>
				</a>
			<?php endforeach ?>
			<div class="pt-2">
				<?php foreach ($GLOBALS['company_contacts']->social_networks as $key => $value): ?>
					<?php if ($value): ?>
						<a href="<?php echo $value; ?>" class="header-social_networks-item h5 p-2">
							<i class="fa fa-<?php echo $key;?>" aria-hidden="true"></i>
						</a>
					<?php endif ?>
				<?php endforeach ?>
			</div>
		</div>
				<?php endif ?>
			</div>
		<?php endforeach ?>


		
	</div>
</div>
<?php get_footer(); ?>