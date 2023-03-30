<?php

$add_template_mat = false;
if (isset($_POST['add_template_mat']) and $_POST['add_template_mat'] == "Y") {
	$template_mat_category = get_category_by_slug('modular_template_mat');
	$add_template_mat = wp_insert_post([
		'post_title' => $_POST['post_title'],
		'post_content' => $_POST['post_content'],
		'post_category' => [$template_mat_category->cat_ID,],
		'post_status' => 'publish',
	]);
}

$edit_template_mat = false;
if (isset($_POST['edit_template_mat'])) {
	$edit_template_mat = wp_update_post([
		'ID' => $_POST['edit_template_mat'],
		'post_title' => $_POST['post_title'],
		'post_content' => $_POST['post_content'],
	]);
}

$delete_template_mat = false;
if (isset($_POST['delete_template_mat'])) {
	$delete_template_mat = wp_delete_post($_POST['delete_template_mat'], true);
}

$template_mat_arr = get_posts([
	'category_name' => 'modular_template_mat',
	'orderby' => 'title',
	'order' => 'ASC',
]);


include_once __DIR__.'/admin-header.php'; 
?>
<div class="container pt-5">

	<div class="h1">
		Материалы для шаблонов модульных картин
	</div>

	<?php if ($edit_template_mat): ?>
		<div class="alert alert-success text-center">
			Изменения внесены в базу данных
		</div>
	<?php endif ?>

	<?php if ($add_template_mat): ?>
		<div class="alert alert-success text-center">
			Новый материал добавлен в базу
		</div>
	<?php endif ?>

	<?php if ($delete_template_mat): ?>
		<div class="alert alert-danger text-center">
			Материал удален из базы данных
		</div>
	<?php endif ?>

	<div class="row">
		<form method="post" action="" class="col-lg-4 col-md-6 col-sm-12 col-12 border">
			<span class="h5 text-info">
				Добавить материал:
			</span>
			<br>
			<span>Материал:</span>
			<input type="text" name="post_title" class="form-control" required>
			<span>Наценка к базовой стоимости шаблона (%):</span>
			<input type="number" class="smart_number form-control" name="post_content" required>
			<br>
			<button class="btn btn-outline-success w-100" name="add_template_mat" value="Y" title="Сохранить">
				<span class="dashicons dashicons-yes"></span>OK
			</button>
		</form>
		<div class="col-lg-6 col-md-8 col-sm-12 col-12">
			<table class="table">
				<tr>
					<th>
						<div class="row">
							<div class="col">
								Материал
							</div>
							<div class="col">
								Наценка (%)
							</div>
						</div>
					</th>
					<th></th>
					<th></th>
				</tr>
				<?php foreach ($template_mat_arr as $key => $value): ?>
					<tr>
						<td>
							<form action="" method="post" class="row">
								<div class="col-6">
									<input type="text" class="forom-control" name="post_title"
							value="<?php echo $value->post_title ?>" required="required">
								</div>
								<div class="col-4">
									<input type="text" class="forom-control w-50" name="post_content"
							value="<?php echo $value->post_content ?>" required="required">
								</div>
								<div class="col-2">
									<button name="edit_template_mat" value="<?php echo $value->ID ?>"
										class="btn btn-outline-success" title="Сохранить">
										<span class="dashicons dashicons-yes"></span>
									</button>
								</div>
							</form>
						</td>
						<td class="text-center">
							<form action="" method="post">
								<button name="delete_template_mat" value="<?php echo $value->ID ?>"
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