<?php

if (isset($GLOBALS['admin_current_gallery']) and $GLOBALS['admin_current_gallery'] == 'wallpaper') {
  $prefix = 'wallpaper_';
} else {
  $prefix = '';
}

$category_edit_alert = [
	'visible' => false,
	'text' => 'error',
	'color' => 'danger'
];

if (isset($_POST['edit_category_image_sorting']) and !empty($_POST['edit_category_image_sorting'])) {
  Admin_modular_category_edit::setImageSorting();
}

$category_edit = new Admin_modular_category_edit($_GET['category_edit'], $prefix);

if (isset($_POST['edit_category_image_delete'])) {
  if ($category_edit->imageDeleteFromCategory($_POST['edit_category_image_delete'])) {
    $category_edit_alert['visible'] = true;
    $category_edit_alert['text'] = 'Изображение удалено из категории';
    $category_edit_alert['color'] = 'danger';
  }
}

if (isset($_POST['edit_category_name']) and $_POST['edit_category_name'] == 'Y') {
	if ($category_edit->setCategoryName($_POST['cat_name'])) {
		$category_edit_alert['visible'] = true;
		$category_edit_alert['text'] = 'Название категории изменено';
		$category_edit_alert['color'] = 'success';
	}
}

if (isset($_POST['edit_category_template'])) {
	if ($category_edit->setCategoryTemplate($_POST['category_template'])) {
		$category_edit_alert['visible'] = true;
    $category_edit_alert['text'] = 'Основной шаблон категории изменен';
    $category_edit_alert['color'] = 'success';
  }
}

if (isset($_POST['edit_category_interior'])) {
  if ($category_edit->setCategoryInterior($_POST['category_interior'])) {
    $category_edit_alert['visible'] = true;
    $category_edit_alert['text'] = 'Основной интерьер категории изменен';
    $category_edit_alert['color'] = 'success';
  }
}

$category_edit->getCategoryById();
$category_edit->getCategoryMeta();
$category_edit->getImagesList();
$category_edit->getCurrentInterior();
$category_edit->getCurrentTemplate();

?>

<div class="container pt-5">


	<?php if ($category_edit_alert['visible']): ?>
		<div class=" text-center alert alert-<?php echo $category_edit_alert['color']; ?>">
			<?php echo $category_edit_alert['text']; ?>
		</div>
	<?php endif ?>

	<div class="row">
		<div class="col-lg-4 col-md-6 col-sm-12 col-12">
			<a href="?page=<?php echo $_GET['page']; ?>" class="btn btn-outline-info">
				<span class="dashicons dashicons-arrow-left-alt2"></span>
				Вернуться в список категорий
			</a>
		</div>
	</div>
	<hr>

	<div class="row">

		<form action="" method="post" class="col-lg-4 col-md-6 col-sm-12 col-12 h6">
			Название категории:
      <div class="row">
       <div class="col-10">
        <input value="<?php echo $category_edit->category->name;?>" class="form-control h-100" type="text" name="cat_name">
      </div>
      <div class="col-2">
        <button name="edit_category_name" value="Y" title="Сохранить" class="btn btn-sm btn-outline-success">
          <span class="dashicons dashicons-yes"></span>
        </button>
      </div>  
    </div>
  </form>

  <?php if (!isset($GLOBALS['admin_current_gallery'])): ?>
    <form action="" method="post" class="col-lg-4 col-md-6 col-sm-12 col-12 h6">
     <div class="row pb-1">
      <div class="col-8">
        Шаблон для категории по умолчанию:
      </div>
      <div class="col-4">
        <img src="<?php echo $photo_galery_url . $category_edit->current_template->thumb_url;?>"
        height="50" class="border" alt="не выбран" style="background: grey;">
      </div>
    </div> 
    <div class="row">
      <div class="col-10">
        <select name="category_template" class="w-100 form-select h-100">
          <option value="">...</option>
          <?php foreach ($category_edit->templates_arr as $key => $value): ?>
            <option value="<?php echo $value->id ?>"
              <?php if ($value->id == $category_edit->template): ?>selected="selected"<?php endif ?>>
              <?php echo $value->slug;?>
            </option>
          <?php endforeach ?>
        </select>
      </div>
      <div class="col-2">
        <button name="edit_category_template" value="Y" title="Сохранить" class="btn btn-sm btn-outline-success">
          <span class="dashicons dashicons-yes"></span>
        </button>
      </div>
    </div>    
  </form>
<?php endif ?>


<form action="" method="post" class="col-lg-4 col-md-6 col-sm-12 col-12 h6">
  <div class="row pb-1">
    <div class="col-8">
      Интерьер для категории по умолчанию:
    </div>
    <div class="col-4">
      <img src="<?php echo $photo_galery_url . $category_edit->current_interior->thumb_url;?>"
      height="50" class="border" alt="не выбран">
    </div>
  </div>  
  <div class="row">
    <div class="col-10">
      <select name="category_interior" class="form-select h-100">
        <option value="">...</option>
        <?php foreach ($category_edit->interior_arr as $key => $value): ?>
          <option value="<?php echo $value->id; ?>"
            <?php if ($value->id == $category_edit->interior): ?>selected="selected"<?php endif ?>>
            <?php echo $value->slug; ?>
          </option>
        <?php endforeach ?>
      </select>
    </div>
    <div class="col-2">
      <button name="edit_category_interior" value="Y" title="Сохранить" class="btn btn-sm btn-outline-success">
        <span class="dashicons dashicons-yes"></span>
      </button>
    </div>   
  </div> 
</form>

</div>
<hr>

<div class="row">
  <div class="col">
    <a href="?page=<?php echo $_GET['page'];?>&category_content=<?php echo $category_edit->category_id; ?>" 
      class="btn btn-outline-info">
      <span class="dashicons dashicons-plus-alt"></span>
      Добавить из каталога
    </a>
  </div>
</div>

<div class="row pt-3">
  <?php foreach ($category_edit->images_list as $key => $value): ?>
    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
      <div class="row border m-1">
        <div style="
        background-image: url(<?php echo $photo_galery_url.$value->thumb_url;?>);
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        height: 75px;
        width: 100px;
        " class="col-7 p-1">
      </div>
      <div class="col-5 p-2">
        <form action="" method="post">
          <?php echo $value->slug; ?>
          <br>
          <button name="edit_category_image_delete" value="<?php echo $value->post_id; ?>" 
            title="Удалить" class="btn btn-sm btn-outline-danger">
            <span class="dashicons dashicons-trash"></span>
          </button>
        </form>
      </div>
      <form action="" method="post" class="pt-1 pb-1 row">
        <div class="col-12">
          Сортировка:
        </div>
        <div class="col-6">
          <input value="<?php echo Admin_modular_category_edit::getImageSorting($value->post_id);?>"
          type="number" name="sorting" class="form-control" step="1" min="1">
        </div>
        <div class="col-6">
          <button name="edit_category_image_sorting"  value="<?php echo $value->post_id;?>" class="btn btn-sm btn-outline-success">
            <span class="dashicons dashicons-yes"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
<?php endforeach ?>
</div>
</div>

<?php

/**
 * 
 */
class Admin_modular_category_edit {

  public static function setImageSorting () {
    update_post_meta($_POST['edit_category_image_sorting'], 'sorting', $_POST['sorting'] );
  }

  public static function getImageSorting ($post_id) {
    $sorting = get_post_meta($post_id, 'sorting');
    if ($sorting) {
      return $sorting[0];
    }
    return '';
  }

  function __construct($category_id, $prefix) {

    global $wpdb;
    $this->prefix = $prefix;
    $this->category_id = $category_id;

    $this->images_list = $this->getImagesList();


    $this->templates_arr = $wpdb->get_results(
     'SELECT * FROM `wp_bwg_gallery`
     JOIN `wp_bwg_image` ON `wp_bwg_image`.`gallery_id`=`wp_bwg_gallery`.`id`
     WHERE `wp_bwg_gallery`.`slug`="modular_templates"'
   );

    $this->interior_arr = $wpdb->get_results(
      'SELECT * FROM `wp_bwg_gallery`
      JOIN `wp_bwg_image` ON `wp_bwg_image`.`gallery_id`=`wp_bwg_gallery`.`id`
      WHERE `wp_bwg_gallery`.`slug`="interiors"'
    );

  }

  function getCurrentInterior () {
    foreach ($this->interior_arr as $key => $value) {
      if ($value->id == $this->interior) {
        $this->current_interior = $value;
      }
    }
  }

  function getCurrentTemplate () {
    foreach ($this->templates_arr as $key => $value) {
      if ($value->id == $this->template) {
        $this->current_template = $value;
      }
    }
  }

  function imageDeleteFromCategory ($post_id) {
    // $post_id = (new WP_Query([
    //   'name' => $this->prefix . $img_id,
    //   'post_type' => 'post',
    // ]))->posts[0]->ID;
    $image_delete = wp_delete_post($post_id);
    if ($image_delete) {
      return true;
    }
    return false;
  }

  function getImagesList () {
    global $wpdb;
    // $arr1 = get_posts([
    //   'post_type' => 'post',
    //   'post_status' => 'publish',
    //   'category' => $this->category_id,
    //   'numberposts' => -1,
    //   'meta_key' => 'sorting',
    //   'orderby' => 'meta_value',
    // ]);
    // if (sizeof($arr1)) {
    //   foreach ($arr1 as $key => $value) {
    //     $post__not_in[] = $value->ID;
    //   }
    // } else {
    //   $post__not_in = [];
    // }
    $arr = get_posts([
      'post_type' => 'post',
      'post_status' => 'publish',
      'category' => $this->category_id,
      'numberposts' => -1,
      'orderby' => 'meta_value_num',
      'meta_query' => array(
        'relation' => 'OR',
        array(
          'key' => 'sorting',
          'compare' => 'EXISTS'
        ),
        array(
          'key' => 'sorting',
          'compare' => 'NOT EXISTS'
        ),
      )
    ]);
    // $arr = array_merge($arr1, $arr2);
    // $arr = array_unique($arr);
    $this->images_list = [];
    foreach ($arr as $key => $value) {
      if ($this->prefix != '') {
        $id = explode($this->prefix, $value->post_name)[1];
      } else {
        $id = $value->post_name;
      }
      $catalog_image = $wpdb->get_results(
        'SELECT * FROM `wp_bwg_image`
        WHERE `id`=' . $id
      );
      if ($catalog_image) {
        $this->images_list[$key] = $catalog_image[0];
      } else {
        $this->images_list[$key] = new stdClass();
        $this->images_list[$key]->id = $value->post_name;
        $this->images_list[$key]->slug = $value->post_title;
      }
      $this->images_list[$key]->post_id = $value->ID;
      // self::getImageSorting($value->id);
    }
  }

  function setCategoryInterior ($interior) {
    return update_term_meta( $this->category_id, 'interior', $interior);
  }

  function setCategoryTemplate ($template) {
    return update_term_meta( $this->category_id, 'template', $template);
  }

  function getCategoryMeta () {
    $template = get_term_meta($this->category_id, 'template');
    if ($template) {
      $this->template = $template[0];
    } else {
      $this->template = false;
    }
    $interior = get_term_meta($this->category_id, 'interior');
    if ($interior) {
      $this->interior = $interior[0];
    } else {
      $this->interior = false;
    }
  }

  function getCategoryById () {
    $this->category = get_category($this->category_id);
  }

  function setCategoryName ($cat_name) {
    return wp_update_category([
     'cat_ID' => $this->category_id,
     'cat_name' => $cat_name,
   ]);
  }

}
?>