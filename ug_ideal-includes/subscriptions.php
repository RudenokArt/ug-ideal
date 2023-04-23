<?php 
$email_subscriptions = new Email_subscriptions(); 
$email_subscriptions_popup = false;
if (isset($_POST['add_new_email_subscriber'])) {
	$email_subscriptions->addNewSubscriber($_POST['email']);
	$email_subscriptions_popup = true;
}


?>
<div class="subscriptions_popup-show text-center text-secondary bg-light border-top border-left border-right border-body">
	<i class="fa fa-chevron-up" aria-hidden="true"></i>
</div>
<div class="subscriptions_popup-wrapper bg-light" id="subscriptions_popup">
	<div class="subscriptions_popup-inner border border-body text-secondary">
		<div class="subscriptions_popup-close text-center bg-light border-top border-left border-right border-body">
			<i class="fa fa-chevron-down" aria-hidden="true"></i>
		</div>
		
		<div class="row justify-content-center pt-5 pb-5">
			<div class="col-lg-4 col-md-6 col-sm-10 col-11">
				<div class="h5">Подписаться на рассылку:</div>
				<form action="" method="post" class="input-group">
					<input type="email" class="form-control" placeholder="@email" name="email">
					<button class="btn btn-outline-secondary" name="add_new_email_subscriber" value="Y">
						<i class="fa fa-check" aria-hidden="true"></i>
					</button>
				</form>
				<div class="">(aкции, новости, скидки, промокоды)</div>
			</div>
		</div>
	</div>
</div>

<?php if ($email_subscriptions_popup): ?>
	<div class="email_subscriptions_popup-wrapper">
		<div class="email_subscriptions_popup-inner">
			<div class="alert alert-success">
				<button class="btn btn-outline-danger" id="email_subscriptions_popup_hide">
						<i class="fa fa-times" aria-hidden="true"></i>
					</button>
					<span>Вы успешно подписаны на рассылку.</span>
			</div>
		</div>
	</div>
<?php endif ?>

<?php if (!$_SESSION['subscriptions_popup']): ?>
	<?php $_SESSION['subscriptions_popup'] = true; ?>
	<script>$('#subscriptions_popup').slideDown(5000, 'swing');</script>
<?php endif ?>
<script>
	$(function () {

		$('.subscriptions_popup-close').click(function () {
			$('#subscriptions_popup').slideUp();
		});

		$('.subscriptions_popup-show').click(function () {
			$('#subscriptions_popup').slideDown();
		});

		$('#email_subscriptions_popup_hide').click(function () {
			$('.email_subscriptions_popup-wrapper').hide();
		});

	});
</script>