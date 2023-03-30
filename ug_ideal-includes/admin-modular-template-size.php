<?php

$add_template_size = false;
if (isset($_POST['add_template_size']) and $_POST['add_template_size'] == "Y") {
	$template_size_category = get_category_by_slug('modular_template_size');
	$add_template_size = wp_insert_post([
		'post_title' => $_POST['post_title'],
		// 'post_content' => $_POST['post_content'],
		'post_category' => [$template_size_category->cat_ID,],
		'post_status' => 'publish',
	]);
}

$edit_template_size = false;
if (isset($_POST['edit_template_size'])) {
	$edit_template_size = wp_update_post([
		'ID' => $_POST['edit_template_size'],
		'post_title' => $_POST['post_title'],
	]);
}

$delete_template_size = false;
if (isset($_POST['delete_template_size'])) {
	$delete_template_size = wp_delete_post($_POST['delete_template_size'], true);
}

$template_size_arr = get_posts([
	'category_name' => 'modular_template_size',
	'orderby' => 'title',
	'order' => 'ASC',
  'numberposts' => 0,
]);

include_once __DIR__.'/admin-header.php';
?>

<pre><?php print_r($_POST); ?></pre>

<div class="container pt-5">
	<div class="h1">
		Размеры для шаблонов модульных картин.
	</div>

	<?php if ($edit_template_size): ?>
		<div class="alert alert-success text-center">
			Изменения внесены в базу данных
		</div>
	<?php endif ?>

	<?php if ($add_template_size): ?>
		<div class="alert alert-success text-center">
			Новый размер добавлен в базу данных
		</div>
	<?php endif ?>

	<?php if ($delete_template_size): ?>
		<div class="alert alert-danger text-center">
			Размер удален из базы данных
		</div>
	<?php endif ?>

	<div class="row border-bottom pb-5">
		<form method="post" action="" class="col-lg-4 col-md-6 col-sm-12 col-12 border">
			<span class="h5 text-info">Добавить размер:</span>
			<br>
			<span>Размер:</span>
			<input type="text" name="post_title" class="form-control" required>
			<!-- <span>Наценка к базовой цене шаблона (%):</span>
			<input type="number" name="post_content" class="form-control smart_number" required> -->
			<br>
			<button class="btn btn-outline-success w-100" name="add_template_size" value="Y" title="Сохранить">
				<span class="dashicons dashicons-yes"></span>OK
			</button>
		</form>
		<div class="col-lg-4 col-md-6 col-sm-12 col-12">
			<table class="table">
				<tr>
					<th>Размер</th>
					<!-- <th>Наценка (%)</th> -->
				</tr>
				<?php foreach ($template_size_arr as $key => $value): ?>
					<tr>
						<td>
							<form action="" method="post" class="row">
								<div class="col-9">
									<input value="<?php echo $value->post_title;?>" type="text" name="post_title" class="form-control" required>
								</div>
								<div class="col-3">
									<button class="btn btn-outline-success" name="edit_template_size"
									value="<?php echo $value->ID ?>" title="Сохранить">
									<span class="dashicons dashicons-yes"></span>
								</button>
								</div>								
							</form>
						</td>
						<!-- <td><?php // echo $value->post_content ?></td> -->
						<td>
							<form action="" method="post">
								<button name="delete_template_size" value="<?php echo $value->ID ?>"
									class="btn btn-outline-danger" title="Удалить">
									<span class="dashicons dashicons-trash"></span>
								</button>
							</form>
						</td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
	</div>
</div>
