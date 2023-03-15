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
			<input type="text" name="post_title" class="form-control">
			<span>Наценка к базовой стоимости шаблона (%):</span>
			<input type="number" class="smart_number form-control" name="post_content">
			<br>
			<button class="btn btn-outline-success w-100" name="add_template_mat" value="Y" title="Сохранить">
				<span class="dashicons dashicons-yes"></span>OK
			</button>
		</form>
		<div class="col-lg-4 col-md-6 col-sm-12 col-12">
			<table class="table">
				<tr>
					<th>Материал</th>
					<th>Наценка (%)</th>
				</tr>
				<?php foreach ($template_mat_arr as $key => $value): ?>
					<tr>
						<td><?php echo $value->post_title ?></td>
						<td><?php echo $value->post_content ?></td>
						<td>
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