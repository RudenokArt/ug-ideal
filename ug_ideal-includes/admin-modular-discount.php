<?php
global $wpdb;
if (isset($_POST['add_modular_discount']) and $_POST['add_modular_discount'] == 'Y') {
  $modular_discount_image = $wpdb->get_results(
    'SELECT * FROM `wp_bwg_image` WHERE `slug`="'.$_POST['post_title'].'"'
  )[0];
  
  $check_modular_discount = new WP_Query([
    'name' => $modular_discount_image->id,
  ]);
  if ($check_modular_discount->post_count == 0) {
    $modular_discount_category = get_category_by_slug('modular_discount');
    $add_modular_discount = wp_insert_post([
      'post_title' => $modular_discount_image->slug,
      'post_name' => $modular_discount_image->id,
      'post_content' => trim($_POST['post_content']),
      'post_category' => [$modular_discount_category->cat_ID,],
      'post_status' => 'publish',
    ]); 
  } 
}

if (isset($_POST['delete_modular_discount'])) {
  $delete_modular_discount = wp_delete_post($_POST['delete_modular_discount'], true);
}

if ($_POST['update_modular_discount']) {
  $update_modular_discount = wp_update_post([
    'ID' => $_POST['update_modular_discount'],
    'post_content' => trim($_POST['post_content']),
  ]); 
}

$modular_discount_arr = get_posts([
  'category_name' => 'modular_discount',
  'orderby' => 'title',
  'order' => 'ASC',
]);

function get_catalog_image_src_by_id ($id) {
  global $wpdb;
  return $wpdb->get_results('SELECT * FROM `wp_bwg_image` WHERE `id`='.$id)[0];
}

include_once __DIR__.'/admin-header.php';
?>


<div class="container pt-5">
  <div class="h1">
    Модульные картины - скидки и акции:
  </div>
  <hr>

  <?php if (isset($add_modular_discount) and $add_modular_discount): ?>
    <div class="alert alert-success text-center">
      Скидка добавлена в базу данных!
    </div>
  <?php elseif (isset($_POST['add_modular_discount']) and $check_modular_discount->post_count > 0):?>
    <div class="alert alert-danger text-center">
      Неверно задан Артикул!
    </div>
  <?php endif ?>

  <?php if (isset($delete_modular_discount)): ?>
    <div class="alert alert-warning text-center">
      Скидка удалена из базы данных!
    </div>
  <?php endif ?>

  <div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
      <div class="h5 text-info">
        Добавить скидку:
      </div>
      <form action="" method="post" class="border p-2">
        Артикул:
        <input type="text" name="post_title" class="form-control" required>
        Размер скидки (%):
        <input type="number" name="post_content" class="form-control smart_number" step="1" min="1" max="100" required>
        <br>
        <button class="btn btn-outline-success" name="add_modular_discount" value="Y">
          <span class="dashicons dashicons-saved"></span> OK
        </button>
      </form>
    </div>
    <div class="col-lg-8 col-md-6 col-sm-12 col-12">
      <table class="table">
        <tr>
          <th>#</th>
          <th>Артикул</th>
          <th>img</th>
          <th>Скидка (%)</th>
        </tr>
        <?php foreach ($modular_discount_arr as $key => $value): ?>
          <tr>
            <td><?php echo $value->post_name; ?></td>
            <td><?php echo $value->post_title; ?></td>
            <td>
              <img
              src="<?php echo $photo_galery_url . get_catalog_image_src_by_id($value->post_name)->thumb_url; ?>"
              width="50"
              alt=""
              >
            </td>
            <td>
              <form action="" method="post">
                <div class="row">
                  <div class="col-6">
                    <input type="number" value="<?php echo $value->post_content;?>"
                    name="post_content" class="form-control smart_number" step="1" max="100" min="1">
                  </div>
                  <div class="col-6">
                    <button name="update_modular_discount" title="Сохранить"
                    value="<?php echo $value->ID; ?>" class="btn btn-outline-success">
                      <span class="dashicons dashicons-saved"></span>
                    </button>
                  </div>
                </div>
              </form>
            </td>
            <td>
              <form action="" method="post">
               <button name="delete_modular_discount" title="Удалить"
               value="<?php echo $value->ID; ?>" class="btn-outline-danger btn">
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