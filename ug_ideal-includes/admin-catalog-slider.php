
<?php

// post-category: catalog_slider
include_once '/ug_ideal-core/Classes/Ug_ideal_catalog_slider.php';
include_once __DIR__.'/admin-header.php'; 
include_once $theme_path.'/ug_ideal-core/Classes/Ug_ideal_catalog_slider.php';
$admin_catalog_slider = new Ug_ideal_catalog_slider();
?>
<div class="container pt-5">
  <?php if ($admin_catalog_slider->alert['visible']): ?>
    <div class="alert-<?php echo $admin_catalog_slider->alert['color'];?> alert text-center">
      <?php echo $admin_catalog_slider->alert['text']; ?>
    </div>
  <?php endif ?>

  <div class="pt-5 mb-5" style="display: flex; width: 100%; overflow-x: auto;">
    <?php foreach ($admin_catalog_slider->slider_list as $key => $value): ?>
      <div class="border" >
        <div class="p-2">
          <img src="<?php echo $photo_galery_url . $value->thumb_url; ?>" height="75" alt="">
          <form action="" method="post">
            <button name="delete_slider_image" value="<?php echo $value->id;?>" class="btn btn-outline-danger mt-1">
              <span class="dashicons dashicons-trash"></span>
              <?php echo $value->slug; ?>
            </button>
          </form>         
        </div>
      </div>
    <?php endforeach ?>
  </div> 

  <?php if (isset($_GET['category'])): ?>
    <form action="" method="post">
      <div class="row pt-5">
        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
          <a href="?page=admin-catalog-slider" class="btn btn-outline-info">
            <span class="dashicons dashicons-exit"></span>
            Назад в список категорий
          </a>
        </div>
        <div class="h3 text-info col-lg-4 col-md-4 col-sm-12 col-12">
          Категория:
          <?php echo $admin_catalog_slider->current_category->name; ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
          <button name="add_sleder_image" value="Y" class="btn btn-outline-success">
            <span class="dashicons dashicons-yes"></span>
            Добавить в слайдер
          </button>
        </div>
      </div>
      <div class="row pt-5">
        <?php foreach ($admin_catalog_slider->images_list as $key => $value): ?>
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 pb-2 border">
            <label class="p-2">
              <img src="<?php echo $photo_galery_url . $value->thumb_url; ?>" height="100" alt="">
              <br>
              <input type="checkbox" name="images_arr[<?php echo $key ?>][id]" value="<?php echo $value->id; ?>">
              <input type="hidden" name="images_arr[<?php echo $key ?>][slug]" value="<?php echo $value->slug; ?>">
              <input type="hidden" name="images_arr[<?php echo $key ?>][category]" value="<?php echo $value->category; ?>">
              <?php echo $value->slug; ?>
            </label>
          </div>
        <?php endforeach ?>
      </div> 
    </form>

  <?php else: ?>
    <div class="row">
      <?php foreach ($admin_catalog_slider->categories_list as $key => $value): ?>
        <div class="col-lg-2 col-md-3 col-sm-6 col-12 pb-3 border">
          <a href="?<?php echo $_SERVER['QUERY_STRING'];?>&category=<?php echo $value->id ?>" class="p-1">
            <?php if (!empty($value->preview_image)): ?>
              <img src="<?php echo $photo_galery_url . $value->preview_image; ?>" height="100" alt="">
            <?php else: ?>
              <img src="<?php echo $photo_galery_url . $value->random_preview_image; ?>" width="100" alt="">
            <?php endif ?>
            <br>
            <?php echo $value->name; ?>
          </a>
        </div>
      <?php endforeach ?>
    </div>
  <?php endif ?>

</div>

