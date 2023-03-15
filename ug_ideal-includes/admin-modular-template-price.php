<?php

if (isset($GLOBALS['admin_current_gallery']) and $GLOBALS['admin_current_gallery'] = 'wallpaper') {
  $current_photo_gallery = 'wallpaper_textures';
  $current_posts_category = 'wallpaper_texture_price';
  $page_h1 = 'Фотообои - базовая цена за кв. метр';
} else {
  $current_photo_gallery = 'modular_templates';
  $current_posts_category = 'modular_template_price';
  $page_h1 = 'Модульные картины - базовые цены шаблонов';
}
global $wpdb;
include_once __DIR__.'/admin-header.php';
$template_price_category = get_category_by_slug($current_posts_category);
if (isset($_POST['post_name']) and isset($_POST['ID'])) {
	$add_template_price = wp_insert_post([
		'ID' => $_POST['ID'],
		'post_name' => $_POST['post_name'],
		'post_title' => $_POST['post_title'],
		'post_content' => $_POST['post_content'],
		'post_category' => [$template_price_category->cat_ID,],
		'post_status' => 'publish',
	]);
} elseif (isset($_POST['post_name'])) {
	$add_template_price = wp_insert_post([
		'post_name' => $_POST['post_name'],
		'post_title' => $_POST['post_title'],
		'post_content' => $_POST['post_content'],
		'post_category' => [$template_price_category->cat_ID,],
		'post_status' => 'publish',
	]);
}

$templates_arr = $wpdb->get_results(
	'SELECT * FROM `wp_bwg_gallery`
	JOIN `wp_bwg_image` ON `wp_bwg_image`.`gallery_id`=`wp_bwg_gallery`.`id`
	WHERE `wp_bwg_gallery`.`slug`="'.$current_photo_gallery.'"'
);

$template_price_arr = get_posts([
	'category_name' => $current_posts_category,
	'orderby' => 'title',
	'order' => 'ASC',
]);


?>


<div class="container mt-5">
   <div class="h1">
    <?php echo $page_h1; ?>:
  </div>
	<table class="table">
		<?php foreach ($templates_arr as $key => $value): ?>
			<tr id="<?php echo 'tr_'.$value->id; ?>">
				<td>
					<?php echo $value->id; ?>
				</td>
				<td>
					<?php echo $value->slug; ?>
				</td>
				<td>
					<img 
					class="bg-secondary"
					height="50"
					src="<?php echo $photo_galery_url . $value->thumb_url; ?>"
					alt="<?php echo $value->slug; ?>"
					>
				</td>
				<td>
					<form action="<?php echo '?'.$_SERVER['QUERY_STRING'].'#tr_'.$value->id; ?>" method="post">
						<div class="row">
							<input type="hidden" name="post_title" value="<?php echo $value->slug ?>">
							<div class="col-3">
								<?php 
								$check_current_template_price = new WP_Query([
									'name' => $value->id,
								]);	
								$current_template_price = 0;
								if ($check_current_template_price->post_count > 0) {
									$current_template_price = $check_current_template_price->posts[0]->post_content;
								}					
								?>
								<?php if ($check_current_template_price->post_count > 0): ?>
									<input value="<?php echo $check_current_template_price->posts[0]->ID;?>"
									type="hidden" name="ID" >
								<?php endif ?>
								<input type="text" value="<?php echo $current_template_price;?>"
								class="form-control" name="post_content">
							</div>
							<div class="col-3">руб.</div>
							<div class="col-6">
								<button class="btn btn-outline-success" name="post_name" value="<?php echo $value->id; ?>">
									<span class="dashicons dashicons-yes"></span>
								</button>
							</div>
						</div>
						
					</form>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
</div>

