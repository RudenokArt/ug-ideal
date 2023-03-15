<?php $wallpaper_roll_width = new Wallpaper_roll_width(); ?>

<?php include_once __DIR__.'/admin-header.php'; ?>

<div class="container pt-5">

  <?php if ($wallpaper_roll_width->allert['visible']): ?>
    <div class="alert-<?php echo $wallpaper_roll_width->allert['color'];?> alert text-center">
      <?php echo $wallpaper_roll_width->allert['text'];?>
    </div>
  <?php endif ?>
  
  <div class="h1">
    Варианты размеров (ширины руллонов) для фотообоев:
  </div>

  <div class="row justify-content-around pt-5">
    <div class="col-lg-4 col-md-6 col-sm-12 col-12 border p-3">
      <div class="h5">
        Добавить размер:
      </div>
      <form action="" method="post">
        Ширина (см):
        <input type="number" class="form-control smart_number" name="post_title" required>
        <!-- Наценка к базовой цене фактуры (%):
        <input type="number" class="form-control smart_number" name="post_content" required> -->
        <br>
        <button class="btn btn-outline-success w-100" name="wallpaper_roll_size_add" value="Y">
          <span class="dashicons dashicons-yes"></span>
        </button>
      </form>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
      <table class="table">
        <tr>
          <th>Ширина (см)</th>
          <!-- <th>Наценка (%)</th> -->
          <th></th>
        </tr>
        <?php foreach ($wallpaper_roll_width->size_list as $key => $value): ?>
         <tr>
           <td>
            <?php echo $value->post_title;?>
          </td>
          <!-- <td><?php // echo $value->post_content;?></td> -->
          <td>
            <form action="" method="post">
              <button name="wallpaper_roll_size_delete" value="<?php echo $value->ID;?>" class="btn btn-outline-danger">
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

<?php

/**
 * 
 */
class Wallpaper_roll_width {

  function __construct() {

    $this->allert = [
      'visible' => false,
    ];

    $this->category = get_category_by_slug('wallpaper_roll_width');

    if (isset($_POST['wallpaper_roll_size_add']) and $_POST['wallpaper_roll_size_add'] == 'Y') {
      $this->add_post = wp_insert_post([
        'post_title' => $_POST['post_title'],
        // 'post_content' => $_POST['post_content'],
        'post_status'  => 'publish',
        'post_category' => [$this->category->cat_ID,],
      ]);
      if ($this->add_post) {
        $this->allert = [
          'visible' => true,
          'color' => 'success',
          'text' => 'Запись добавлена в базу данных',
        ];
      } else {
        $this->allert = [
          'visible' => true,
          'color' => 'danger',
          'text' => 'Ошибка базы данных',
        ];
      }
    }

    if (isset($_POST['wallpaper_roll_size_delete'])) {
      $this->delete_post = wp_delete_post($_POST['wallpaper_roll_size_delete'], true);
      if ($this->delete_post) {
        $this->allert = [
          'visible' => true,
          'color' => 'warning',
          'text' => 'Запись удалена из базы данных',
        ];
      } else {
        $this->allert = [
          'visible' => true,
          'color' => 'danger',
          'text' => 'Ошибка базы данных',
        ];
      }
    }

    $this->size_list = get_posts([
      'category_name' => 'wallpaper_roll_width',
      'orderby' => 'title',
      'order' => 'ASC',
      'numberposts' => 0,
    ]);
  }
}

?>