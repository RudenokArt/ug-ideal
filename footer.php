

<div class="theme_color">
	<div class="container pt-3 text_color pb-3 mt-5">
		<div class="row">
			<div class="col-lg-4 col-md-12 col-sm-12 col-12">
				<div class="h4">
					<?php echo $GLOBALS['company_contacts']->company_name; ?>
				</div>
				<?php foreach ($GLOBALS['company_contacts']->company_address as $key => $value): ?>
					<div class="pt-1">
						<?php echo $value->post_title; ?>
					</div>
				<?php endforeach ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-12">
				<?php foreach ($GLOBALS['company_contacts']->company_phones as $key => $value): ?>
					<a href="tel:<?php echo $value; ?>" class="d-block text_color text_hover_color pt-1 footer-phone">
						<?php echo $value; ?>
					</a>
				<?php endforeach ?>
				<?php foreach ($GLOBALS['company_contacts']->company_email as $key => $value): ?>
					<a href="mailto:<?php echo $value; ?>" class="d-block text_color text_hover_color pt-1 footer-email">
						<?php echo $value; ?>
					</a>
				<?php endforeach ?>
				<div class="pt-2">
					<?php foreach ($GLOBALS['company_contacts']->social_networks as $key => $value): ?>
						<?php if ($value): ?>
							<a href="<?php echo $value; ?>" class="header-social_networks-item h5 p-2 text_color text_hover_color">
								<i class="fa fa-<?php echo $key;?>" aria-hidden="true"></i>
							</a>
						<?php endif ?>
					<?php endforeach ?>
				</div>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-12">
				<form action="" method="post">
					<input type="text" class="form-control m-2" placeholder="Имя" required name="user_name">
					<input type="email" class="form-control m-2" placeholder="@Email" required name="user_email">
					<textarea name="user_message" class="form-control m-2" required></textarea>
					<button class="btn btn-secondary m-2 w-100" name="footer_feedback_form" value="Y">
						<i class="fa fa-envelope-o" aria-hidden="true"></i>
						Отправить
					</button>
				</form>
			</div>
		</div>
	</div>
</div>

<?php include_once 'ug_ideal-includes/subscriptions.php'; ?>

<?php
/**
 * The template for displaying the footer.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

</div>
</div>

<?php
/**
 * generate_before_footer hook.
 *
 * @since 0.1
 */
do_action( 'generate_before_footer' );
?>

<div <?php generate_do_attr( 'footer' ); ?>>
	<?php
	/**
	 * generate_before_footer_content hook.
	 *
	 * @since 0.1
	 */
	do_action( 'generate_before_footer_content' );

	/**
	 * generate_footer hook.
	 *
	 * @since 1.3.42
	 *
	 * @hooked generate_construct_footer_widgets - 5
	 * @hooked generate_construct_footer - 10
	 */
	// do_action( 'generate_footer' ); // Старый футер

	/**
	 * generate_after_footer_content hook.
	 *
	 * @since 0.1
	 */
	do_action( 'generate_after_footer_content' );
	?>
</div>

<?php
/**
 * generate_after_footer hook.
 *
 * @since 2.1
 */
do_action( 'generate_after_footer' );

wp_footer();
?>

</body>
</html>
