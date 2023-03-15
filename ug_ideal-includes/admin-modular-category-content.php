<?php 

if (isset($GLOBALS['admin_current_gallery']) and $GLOBALS['admin_current_gallery'] == 'wallpaper') {
  $prefix = 'wallpaper_';
} else {
  $prefix = '';
}

if (isset($_POST['category_content_add']) and $_POST['category_content_add'] == 'Y') {
  if (isset($_POST['post_name'])) {
    foreach ($_POST['post_name'] as $key => $value) {
      $category_content_add = wp_insert_post([
        'post_title' => $_POST['post_title'][$key],
        'post_category' => [$_GET['category_content']],
        'post_name' => $prefix . $value,
        'post_status' => 'publish',
      ]);
    }  
  }
  header('Location: ?page='.$_GET['page'].'&category_edit='.$_GET['category_content']);
} 

$category_content = new Admin_modular_category_content($prefix);

?>

<style>
  .category_content-catalog_image {
    overflow: hidden;
  }
</style>


<div class="container pt-5">


  <div class="pt-3 h4">
    Выбор изображений для категории
    <span><?php echo $category_content->category->name; ?></span>
  </div>
  <hr>


  <?php if (isset($_GET['catalog_gallery'])): ?>

    <form action="" method="post">
      <div class="row justify-content-between pt-3">
        <div class="col h5">
          Из галлереи:
          <span><?php echo $category_content->catalog_gallery->name; ?></span>
        </div>
        <div class="col">
          <button name="category_content_add" value="Y" class="btn btn-outline-success">
            <span class="dashicons dashicons-yes"></span>
            Добавить
          </button>
        </div>
        <div class="col">
          <a href="?page=<?php echo $_GET['page'];?>&category_content=<?php echo $_GET['category_content'];?>" class="btn btn-outline-danger">
            <span class="dashicons dashicons-no"></span>
            Отмена
          </a>
        </div>
      </div>
      <div class="row pt-3">
        <?php foreach ($category_content->catalog_images_list as $key => $value): ?>
         <label class="col-lg-2 col-md-3 col-sm-4 col-6 border category_content-catalog_image">
          <input class="form-check-input" value="<?php echo $value->id; ?>" type="checkbox" name="post_name[]">
          <input value="<?php echo $value->slug; ?>" style="display: none;" type="checkbox" name="post_title[]">
          <?php echo $value->slug; ?>
          <br>
          <img src="<?php echo $photo_galery_url.$value->thumb_url; ?>"
          alt="<?php echo $value->alt; ?>" height="100">
        </label>
      <?php endforeach ?>
    </div>
  </form>

<?php else: ?>

  <div class="row pt-3">
    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
      <a href="?page=<?php echo $_GET['page'];?>&category_edit=<?php echo $_GET['category_content'];?>" class="btn btn-outline-info">
        <span class="dashicons dashicons-arrow-left-alt2"></span>
        Назад в настройки категории
      </a>
    </div>
  </div>

  <div class="row pt-3">
    <?php foreach ($category_content->catalog_galleries_list as $key => $value): ?>
      <a href="?<?php echo $_SERVER['QUERY_STRING'] ?>&catalog_gallery=<?php echo $value->id; ?>"
        class="col-lg-2 col-md-3 col-sm-4 col-6 border">
        <?php echo $value->name; ?>
        <br>
        <?php if ($value->preview_image): ?>
          <img src="<?php echo $photo_galery_url.$value->preview_image ?>" alt="<?php echo $value->name; ?>" width="100">
        <?php else: ?>
          <img src="<?php echo $photo_galery_url.$value->random_preview_image ?>" alt="<?php echo $value->name; ?>" width="100">
        <?php endif ?>
      </a>
    <?php endforeach ?>
  </div>

<?php endif ?>
</div>


<script>
  $('input[name="post_name[]"]').change(function () {
    $(this).siblings('input[name="post_title[]"]')[0].checked = this.checked;
  });
</script>

<?php 
/**
 * 
 */
class Admin_modular_category_content {

  function __construct($prefix) {
    global $wpdb;
    $this->prefix = $prefix;
    if (isset($GLOBALS['admin_current_gallery']) and $GLOBALS['admin_current_gallery'] == 'wallpaper') {
      $this->modular_pictures_category = get_category_by_slug('wallpaper');
    } else {
      $this->modular_pictures_category = get_category_by_slug('modular_pictures');
    }

    

    $this->category = get_category($_GET['category_content']);

    if (isset($_GET['catalog_gallery'])) {
      $this->check_list = $this->getCheckList();
      $this->catalog_gallery = $wpdb->get_results(
        'SELECT * FROM `wp_bwg_gallery`
        WHERE `id`='.$_GET['catalog_gallery']
      )[0];
      $catalog_images_list = $wpdb->get_results(
        'SELECT * FROM `wp_bwg_image`
        WHERE `gallery_id`="'.$_GET['catalog_gallery'].'"'
      );
      $this->catalog_images_list = [];
      foreach ($catalog_images_list as $key => $value) {
        if (!in_array($value->id, $this->check_list)) {
          $this->catalog_images_list[] = $value;
        }
      }
    } else {
      $this->catalog_galleries_list = $wpdb->get_results(
        'SELECT 
        `wp_bwg_gallery`.`id`,
        `wp_bwg_gallery`.`name`,
        `wp_bwg_gallery`.`preview_image`,
        `wp_bwg_gallery`.`random_preview_image`
        FROM `wp_bwg_album`
        JOIN `wp_bwg_album_gallery`
        ON `wp_bwg_album`.`id`=`wp_bwg_album_gallery`.`album_id`
        JOIN `wp_bwg_gallery`
        ON `wp_bwg_album_gallery`.`alb_gal_id`=`wp_bwg_gallery`.`id`
        WHERE `wp_bwg_album`.`slug`="catalog"'
      );
    }
  }

  function getCheckList () {
    $arr = get_posts([
      'category' => $this->modular_pictures_category->cat_ID,
      'numberposts' => -1,
      'posts_per_page' => -1,
    ]);
    foreach ($arr as $key => $value) {
      if ($this->prefix != '') {
        $id = explode($this->prefix, $value->post_name)[1];
      } else {
        $id = $value->post_name;
      }
      $check_list[] = $id;
    }
    if ($arr) {
      return $check_list;
    }
    return [];
  }

}

?>
