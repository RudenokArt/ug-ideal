<?php 
include_once __DIR__.'/admin-header.php';
$modular_dimensions = new ModularDimensions();
?>

<div class="container pt-5">
	<div class="row pb-5">
		<div class="col-12 h3">
			Габариты для загрузки в Yandex.Market
		</div>
		<div class="h6 text-danger">
			Вес и габариты указывать для товара в упаковке!
		</div>
	</div>
	<?php foreach ($modular_dimensions->templates_list as $key => $value): ?>
		<form method="post" action="#<?php echo $value->id;?>" class="row border-bottom" id="<?php echo $value->id;?>">			
			<input type="hidden" name="template_id" value="<?php echo $value->id;?>">
			<input type="hidden" name="template_title" value="<?php echo $value->slug;?>">
			<div class="col-2">
				<div><?php echo $value->slug;?> (<?php echo $value->id; ?>)</div>
				<div class="bg-secondary">
					<img src="<?php echo $photo_galery_url.$value->thumb_url; ?>" class="w-100">
				</div>
				<div>
					<button name="modular_dimensions_save" class="btn btn-sm btn-outline-success w-100" value="Y" title="сохранить">
						<span class="dashicons dashicons-yes"></span>
						Сохранить
					</button>
				</div>
			</div>
			<div class="col-10">
				<?php foreach ($modular_dimensions->size_list as $key1 => $value1): ?>
					<div class="row border-bottom p-1">
						<div class="col-2">
							<?php echo $value1->ID;?><br>
							<?php echo $value1->post_title; ?>
						</div>
						<div class="col-2">
							Длинна (см):
							<input
							name="size_list[<?php echo $value1->ID;?>][length]"
							<?php if (isset($modular_dimensions->dimensions_arr[$value->id])): ?>
								<?php if ($modular_dimensions->dimensions_arr[$value->id]['size_list'][$value1->ID]): ?>
									value="<?php echo $modular_dimensions->dimensions_arr[$value->id]['size_list'][$value1->ID]['length'] ?>"
								<?php endif ?>
							<?php endif ?>
							type="number" step="1" min="1" max="1000" class="form-control" required>
						</div>
						<div class="col-2">
							Ширина (см):
							<input
							name="size_list[<?php echo $value1->ID;?>][width]"
							<?php if (isset($modular_dimensions->dimensions_arr[$value->id])): ?>
								<?php if ($modular_dimensions->dimensions_arr[$value->id]['size_list'][$value1->ID]): ?>
									value="<?php echo $modular_dimensions->dimensions_arr[$value->id]['size_list'][$value1->ID]['width'] ?>"
								<?php endif ?>
							<?php endif ?>
							type="number" step="1" min="1" max="1000" class="form-control" required>
						</div>
						<div class="col-2">
							Высота (см):
							<input
							name="size_list[<?php echo $value1->ID;?>][height]"
							<?php if (isset($modular_dimensions->dimensions_arr[$value->id])): ?>
								<?php if ($modular_dimensions->dimensions_arr[$value->id]['size_list'][$value1->ID]): ?>
									value="<?php echo $modular_dimensions->dimensions_arr[$value->id]['size_list'][$value1->ID]['height'] ?>"
								<?php endif ?>
							<?php endif ?>
							type="number" step="1" min="1" max="1000" class="form-control" required>
						</div>
						<div class="col-2">
							Вес (кг):
							<input name="size_list[<?php echo $value1->ID;?>][weight]"
							<?php if (isset($modular_dimensions->dimensions_arr[$value->id])): ?>
								<?php if ($modular_dimensions->dimensions_arr[$value->id]['size_list'][$value1->ID]): ?>
									value="<?php echo $modular_dimensions->dimensions_arr[$value->id]['size_list'][$value1->ID]['weight'] ?>"
								<?php endif ?>
							<?php endif ?>
							type="number" step="1" min="1" max="1000" class="form-control" required>
						</div>
						<div class="col-2">
							<label title="Основной размер для выгрузки по умолчанию">
								Основной: <br>
								<input 
								<?php if (isset($modular_dimensions->dimensions_arr[$value->id]['default_size'])): ?>
									<?php if ($modular_dimensions->dimensions_arr[$value->id]['default_size'] == $value1->ID): ?>
										checked
									<?php endif ?>
								<?php endif ?>
								value="<?php echo $value1->ID;?>"
								type="radio" name="default_size" required>
							</label>					
						</div>
					</div>
				<?php endforeach ?>
				<?php if (isset($modular_dimensions->dimensions_arr[$value->id]['post_id'])): ?>
					<input value="<?php echo $modular_dimensions->dimensions_arr[$value->id]['post_id'];?>"
					name="ID"	type="hidden">
				<?php endif ?>		
			</div>
		</form>
	<?php endforeach ?>
</div>


<?php

/**
 * 
 */
class ModularDimensions {
	function __construct() {
		$this->dimensions_category = $this->getDimensionsCategory();
		$this->photo_gallery = 'modular_templates';
		$this->templates_list = $this->getTemplatesList();
		$this->size_list = (new WP_Query([
			'category_name' => 'modular_template_size',
			'nopaging' => true,
			'orderby' => 'ID',
			'order' => 'ASC',
		]))->posts;

		if (isset($_POST['modular_dimensions_save'])) {
			$this->dimensionsSave();
		}

		$this->dimensions_list = (new WP_Query([
			'category_name' => $this->dimensions_category->slug,
			'nopaging' => true,
			'orderby' => 'ID',
			'order' => 'ASC',
		]))->posts;

		foreach ($this->dimensions_list as $key => $value) {
			$dimensions_arr = json_decode($value->post_content, true);
			$dimensions_arr['post_id'] = $value->ID;
			$this->dimensions_arr[$dimensions_arr['template_id']] = $dimensions_arr; 
		}

	}

	public function dimensionsSave () {
		$arr = $_POST;
		$json_data = json_encode($arr);
		$post_id = wp_insert_post([
			'post_title' => $arr['template_title'],
			'post_name' => 'modular_dimensions-'.$arr['template_id'],
			'post_content' => $json_data,
			'post_status' => 'publish',
			'post_type' => 'post',
			'post_category' => [$this->dimensions_category->cat_ID],
		]);
	}

	public function getDimensionsCategory()	{
		$category = get_category_by_slug('modular_dimensions');
		if (!$category) {
			$cat = wp_insert_category([
				'cat_ID' => 0,
				'cat_name' => 'Модульные картины - габариты',
				'category_nicename' => 'modular_dimensions',
				'category_description' => 'Габариты модульных картин для загрузки в маркет',

			]);
			$category = get_category_by_slug('modular_dimensions');
		}
		return $category;
	}


	public function getTemplatesList () {
		global $wpdb;
		$template = $wpdb->get_results(
			'SELECT 
			`wp_bwg_image`.`id`,
			`wp_bwg_image`.`slug`,
			`wp_bwg_image`.`image_url`,
			`wp_bwg_image`.`thumb_url`,
			`wp_bwg_image`.`filetype`,
			`wp_bwg_image`.`filename`
			FROM `wp_bwg_gallery`
			JOIN `wp_bwg_image` ON `wp_bwg_image`.`gallery_id`=`wp_bwg_gallery`.`id`
			WHERE `wp_bwg_gallery`.`slug`="'.$this->photo_gallery.'"'
		);
		return $template;
	}
}

?>

