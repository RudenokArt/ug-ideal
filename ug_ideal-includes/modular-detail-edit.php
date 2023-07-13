<?php 
$detail_edit = new DetailEdit($_GET['edit']);

?>
<link rel="stylesheet" href="<?php echo $theme_url;?>/ug_ideal-assets/css/modular-detail-edit.css">
<form action="" method="post" class="container pt-5 pb-5" id="detail_edit">
	<div class="row pb-5">
		<div class="col-lg-6 col-md-6 col-sm-12 col-12 pt-5" style="position: relative">
			<div class="modular-edit-image_wrapper">
				<img src="<?php echo $photo_galery_url.$detail_edit->catalog_image_url;?>"
				v-bind:style="imageStyle" class="modular-edit-image" alt="">
				<img style="opacity: 0.8;"
				v-bind:src="`<?php echo $photo_galery_url;?>${templates_arr[template_index].image_url}`" alt="">
			</div>
			<img v-if="interiors_arr[interior_index].image_url"
			v-bind:src="`<?php echo $photo_galery_url;?>${interiors_arr[interior_index].image_url}`"
			class="modular-edit-interior" alt="">	
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-12 pt-5">
			<div class="row pb-5">
				<div class="col-6">
					<a href="<?php echo $_SESSION['back_page_url'];?>" class="btn btn-outline-warning w-100">
						<i class="fa fa-times" aria-hidden="true"></i>
						Отмена
					</a>
				</div>
				<div class="col-6">
					<button class="btn btn-outline-success w-100" name="detail_edit" value="Y">
						<i class="fa fa-floppy-o" aria-hidden="true"></i>
						Сохранить
					</button>
				</div>
			</div>
			Шаблон для изображения:
			<select v-model="template_index" class="form-select" name="template">
				<option v-for="(item, index) in templates_arr" v-bind:value="index">
					{{item.slug}}
				</option>
			</select>
			Интерьер для изображения:
			<select v-model="interior_index" class="form-select" name="interior">
				<option v-for="(item, index) in interiors_arr" v-bind:value="index">
					{{item.slug}}
				</option>
			</select>
			<div class="text-info pt-4">
				<i class="fa fa-arrows-v" aria-hidden="true"></i>
				{{verticalPosition}}
				<label class="form-label w-100">
					<input v-model="verticalPosition" type="range" name="top" class="form-range w-100" min="-50" max="50">
				</label>
				<i class="fa fa-arrows-h" aria-hidden="true"></i>
				{{horizontalPosition}}
				<label class="form-label w-100">
					<input v-model="horizontalPosition" type="range" name="left" class="form-range w-100" min="-50" max="50">
				</label>
				<i class="fa fa-expand" aria-hidden="true"></i>
				{{imageSize}}
				<label class="form-label w-100">
					<input v-model="imageSize" type="range" name="width" class="form-range w-100" min="50" max="150">
				</label>

				<div class="form-check form-switch">
					<input name="image_expand" v-model="imageExpand" class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
					<label class="form-check-label" for="flexSwitchCheckChecked">
						Растянуть изображение на весь блок
					</label>
				</div>

			</div>
		</div>
	</div>
	<input type="hidden" v-bind:value="templates_arr[template_index].id" name="template_id">
	<input type="hidden" v-bind:value="interiors_arr[interior_index].id" name="interior_id">

	<div class="row pt-5">
		<div class="col-12 h5 text-secondary">
			<div class="alert aletr-light text-center border">
				Выгрузка в маркет:
			</div>
		</div>

		<div class="col-12">
			<div class="row pb-3">
				<div class="col-lg-3 col-md-4 col-sm-12">
					<div class="alert alert-light p-1 m-0">
						Название товара:
					</div>				
				</div>
				<div class="col-lg-9 col-md-8 col-sm-12">
					<input v-bind:value="description" name="product" type="text" class="form-control p-1">
				</div>
			</div>
		</div>

		<div class="col-12 pb-3">
			<div class="row">
				<div class="col-12">
					Описание товара:
				</div>
				<div class="col-12">
					<textarea name="description" class="form-control">{{description}}</textarea>
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-6 col-sm-12">
			<div class="row pb-2">
				<div class="col-6 border-bottom text-end pt-1">
					Материал:
				</div>
				<div class="col-6">
					<select name="material" class="form-select" v-model="modular_template_mat">
						<?php foreach ($detail_edit->modular_template_mat as $key => $value): ?>
							<option><?php echo $value->post_title; ?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-6 col-sm-12">
			<div class="row pb-2">
				<div class="col-6 border-bottom text-end pt-1">
					Размер:
				</div>
				<div class="col-6">
					<select name="size" class="form-select" v-model="modular_template_size">
						<?php foreach ($detail_edit->modular_template_size as $key => $value): ?>
							<option><?php echo $value->post_title; ?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-6 col-sm-12">
			<div class="row pb-2">
				<div class="col-8 border-bottom text-end">
					Стоимость (руб):
				</div>
				<div class="col-4">
					<input name="market_price" type="number" class="form-control p-1">
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-6 col-sm-12">
			<div class="row pb-2">
				<div class="col-8 border-bottom text-end">
					Длинна в упаковке (см):
				</div>
				<div class="col-4">
					<input name="market_length" type="number" class="form-control p-1">
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-6 col-sm-12">
			<div class="row pb-2">
				<div class="col-8 border-bottom text-end">
					Ширина в упаковке (см):
				</div>
				<div class="col-4">
					<input name="market_width" type="number" class="form-control p-1">
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-6 col-sm-12">
			<div class="row pb-2">
				<div class="col-8 border-bottom text-end">
					Высота в упаковке (см):
				</div>
				<div class="col-4">
					<input name="market_height" type="number" class="form-control p-1">
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-6 col-sm-12">
			<div class="row pb-2">
				<div class="col-8 border-bottom text-end">
					Вес в упаковке (кг):
				</div>
				<div class="col-4">
					<input name="market_weight" type="number" class="form-control p-1">
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-6 col-sm-12">
			<button v-on:click="yaSave" type="button" class="btn btn-outline-primary w-100">
				<i class="fa fa-floppy-o" aria-hidden="true"></i>
				Сохранить в каталог
			</button>
		</div>

	</div>
</form>

<script>
	new Vue ({
		el: '#detail_edit',
		data: {
			templates_arr: JSON.parse('<?php echo $detail_edit->templates_json;?>'),
			template_index: '<?php echo $detail_edit->template_index; ?>',
			interiors_arr: JSON.parse('<?php echo $detail_edit->interiors_json;?>'),
			interior_index: '<?php echo $detail_edit->interior_index; ?>',
			verticalPosition: '<?php echo $detail_edit->top; ?>',
			horizontalPosition: '<?php echo $detail_edit->left; ?>',
			imageSize: '<?php echo $detail_edit->width; ?>',
			imageExpand: '<?php echo $detail_edit->image_expand; ?>',

			modular_template_mat: '',
			modular_template_size: '',

		},

		methods: {
			yaSave: async function () {
				var frmDt = new FormData(document.querySelector('#detail_edit'));
				frmDt.set('image', '<?php echo $detail_edit->img_json; ?>');
				frmDt.set('template', JSON.stringify(this.templates_arr[this.template_index]));
				frmDt.set('folder', '<?php echo $photo_galery_url ?>');
				var dataArr = Array.from(frmDt);
				var imgQueryString = new URLSearchParams(dataArr).toString();
				var image = await $.get('<?php echo $theme_url;?>/ug_ideal-core/ModularOrderImage.php?'+imgQueryString);
				var productParams = new URLSearchParams();
				productParams.set('ya_market', 'Y');
				productParams.set('save', 'Y');
				productParams.set('post_slug', 'yandex_modular_<?php echo $detail_edit->post->post_name;?>');
				productParams.set('shopSku', 'yandex_modular_<?php echo $detail_edit->post->post_name;?>');
				productParams.set(
					'pictures',
					"<?php if (isset($_SERVER['HTTPS'])) {
						$http_protocol = 'https://';
					} else {
						$http_protocol = 'http://';
					}
					echo $http_protocol.$_SERVER['HTTP_HOST']; ?>/wp-content/uploads/yandex_market/" + 
					"yandex_modular_<?php echo $detail_edit->post->post_name;?>.jpg"
					);
				productParams.set('name', frmDt.get('product'));
				productParams.set('description', frmDt.get('description'));
				productParams.set('vendorCode', '<?php echo $detail_edit->post->post_title;?>');
				productParams.set('length', frmDt.get('market_length'));
				productParams.set('width', frmDt.get('market_width'));
				productParams.set('height', frmDt.get('market_height'));
				productParams.set('weight', frmDt.get('market_weight'));
				productParams.set('price', frmDt.get('market_price'));
				productParams.set(
					'urls',
					document.location.origin +
					document.location.pathname +
					'?id=<?php echo $detail_edit->post->post_name; ?>'
					);
				var productQueryString = productParams.toString();
				var product = await $.get('<?php echo $theme_url;?>/ug_ideal-core/ajax.php?'+productQueryString);
				console.log(product);
				if (product) {
					alert('Товар добавлен в каталог!');
				}
			}
		},

		computed: {
			description: function () {
				return 'Модульная картина: ' + this.templates_arr[this.template_index].slug +
				' Материал: ' + this.modular_template_mat + 
				' Размер: ' + this.modular_template_size + 
				' Артикул: <?php echo $detail_edit->post->post_title;?>';
			},
			imageStyle: function () {
				var style = {
					'width': + this.imageSize + '%',
					'max-width': + this.imageSize + '%',
					'top': this.verticalPosition + '% ',
					'left': this.horizontalPosition + '% ',
				};
				return style;
			},

		},
	});
</script>


<?php 

/**
 * 
 */
class DetailEdit {
	
	function __construct($post_id) {

		$this->post_id = $post_id;
		$this->post = get_posts(['p' => $this->post_id])[0];
		$this->catalog_image_url = $this->getCatalogImageUrl();
		$this->templates_arr = $this->getGalleryArr('modular_templates');
		$this->templates_json = json_encode($this->templates_arr);
		$this->interiors_arr = $this->getGalleryArr('interiors');
		$default_interior = new stdClass;
		$default_interior->slug = 'Без интерьера';
		array_unshift($this->interiors_arr, $default_interior);
		$this->interiors_json = json_encode($this->interiors_arr);
		$this->postContentParse();
		if (isset($_POST['detail_edit']) and $_POST['detail_edit'] == 'Y') {
			$this->updatePostContent();
		}

		$this->modular_template_mat = get_posts(['category_name' => 'modular_template_mat',]);
		$this->modular_template_size = get_posts(['category_name' => 'modular_template_size',]);
	}

	function postContentParse () {
		$this->template_index = 0;
		$this->interior_index = 0;
		$this->top = 0;
		$this->left = 0;
		$this->width = 100;
		if ($this->post->post_content) {
			$content = json_decode($this->post->post_content, true);
			if (isset($content['top'])) {
				$this->top = $content['top'];
			}
			if (isset($content['left'])) {
				$this->left = $content['left'];
			}
			if (isset($content['width'])) {
				$this->width = $content['width'];
			}
			if (isset($content['image_expand'])) {
				$this->image_expand = $content['image_expand'];
			}
			if (isset($content['template_id'])) {
				foreach ($this->templates_arr as $key => $value) {
					if ($value->id == $content['template_id']) {
						$this->template_index = $key;
					}
				}
			}
			if (isset($content['interior_id'])) {
				foreach ($this->interiors_arr as $key => $value) {
					if ($value->id == $content['interior_id']) {
						$this->interior_index = $key;
					}
				}
			}			
		}
	}

	function updatePostContent () {
		$content = json_decode($this->post->post_content, true);
		if (!$content) {
			$content = [];
		}
		$content['image_expand'] = $_POST['image_expand'];
		$content['template_id'] = $_POST['template_id'];
		$content['interior_id'] = $_POST['interior_id'];
		$content['top'] = $_POST['top'];
		$content['left'] = $_POST['left'];
		$content['width'] = $_POST['width'];
		$content['image_expand'] = $_POST['image_expand'];
		wp_update_post([
			'ID' => $this->post_id,
			'post_content' => json_encode($content),
		]);
		echo '<meta http-equiv="refresh" content="0; url='.$_SESSION['back_page_url'].'" />';
		exit();
	}

	function getGalleryArr ($gallery_slug) {
		global $wpdb;
		$arr = $wpdb->get_results(
			'SELECT * FROM `wp_bwg_gallery`
			JOIN `wp_bwg_image` 
			ON `wp_bwg_image`.`gallery_id`=`wp_bwg_gallery`.`id`
			WHERE `wp_bwg_gallery`.`slug`="'.$gallery_slug.'"'
		);
		if ($arr) {
			return $arr;
		}
		return false;
	}

	function getCatalogImageUrl () {
		global $wpdb;
		$img = $wpdb->get_results(
			'SELECT `image_url`, `filetype` 
			FROM `wp_bwg_image`
			WHERE `id`='.$this->post->post_name
		);
		if ($img) {
			$this->img_json = json_encode($img[0], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
			return $img[0]->image_url;
		}
		return false;
	}

}

?>