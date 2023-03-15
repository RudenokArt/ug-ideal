

<?php include_once __DIR__.'/admin-header.php'; ?>
<?php if (isset($_GET['category_edit'])): ?>
	<?php include_once 'admin-modular-category-edit.php'; ?>
<?php elseif(isset($_GET['category_content'])): ?>
  <?php include_once 'admin-modular-category-content.php' ?>
<?php else: ?>

  <?php

  if (isset($GLOBALS['admin_current_gallery']) and $GLOBALS['admin_current_gallery'] == 'wallpaper') {
    $modular_pictures_category = get_category_by_slug('wallpaper');
  } else {
    $modular_pictures_category = get_category_by_slug('modular_pictures');
  }

  $modular_category_alert = [
    'visible' => false,
    'text' => 'error',
    'color' => 'danger'
  ];

  if (isset($_POST['modular_add_category']) and $_POST['modular_add_category'] == 'Y') {
   $modular_add_category = wp_insert_category([
    'cat_name' => $_POST['cat_name'],
    'category_parent' => $_POST['category_parent'],
  ]);
   $modular_category_alert['visible'] = true;
   $modular_category_alert['text'] = 'Запись добавлена в базу данных';
   $modular_category_alert['color'] = 'success';
 }

 if (isset($_POST['modular_delete_category'])) {
  $delete_category_check_subcategories = get_categories([
    'hide_empty' => false,
    'taxonomy' => 'category',
    'parent' => $_POST['modular_delete_category'],
  ]);
  $delete_category_check_posts = get_posts([
    'category' => $_POST['modular_delete_category'],
  ]);
  if (
    sizeof($delete_category_check_subcategories) == 0
    and
    sizeof($delete_category_check_posts) == 0
  ) {
    if (wp_delete_term( $_POST['modular_delete_category'], 'category' )) {
      $modular_category_alert['visible'] = true;
      $modular_category_alert['text'] = 'Категория удалена!';
      $modular_category_alert['color'] = 'danger';
    }
  } else {
    $modular_category_alert['visible'] = true;
    $modular_category_alert['text'] = 'Удаление невозможно. Категория содержит дочерние элементы!';
    $modular_category_alert['color'] = 'danger';
  }
}


$modular_categories_arr = get_categories([
	'hide_empty' => false,
	'taxonomy' => 'category',
	'parent' => $modular_pictures_category->cat_ID,
	'orderby' => 'name',
]);

$modular_current_category = $modular_categories_arr[0]->cat_ID;
if (isset($_GET['current_category'])) {
	$modular_current_category = $_GET['current_category'];
}
if (isset($modular_add_category)) {
  $modular_current_category = $_POST['category_parent'];
}

$modular_subcategories_arr = get_categories([
	'hide_empty' => false,
	'taxonomy' => 'category',
	'parent' => $modular_current_category,
	'orderby' => 'name',
]);

?>

<div class="container pt-5">
  <?php if ($modular_category_alert['visible']): ?>
    <div class="row">
     <div class="col text-center">
      <div class="alert alert-<?php echo $modular_category_alert['color'];?>">
       <?php echo $modular_category_alert['text']; ?>
     </div>
   </div>
 </div>	
<?php endif ?>

<div class="row pt-5">
  <div class="col-lg-6 col-md-6 col-sm-12 col-12">
   <form method="post" action="" class="row m-1 pb-3 mb-5 border">
    <div class="col-12">
     Добавить категорию:
   </div>
   <div class="col-lg-10 col-md-12 col-sm-12 col-12 pt-1">
     <input type="hidden" name="category_parent" value="<?php echo $modular_pictures_category->cat_ID;?>">
     <input type="text" name="cat_name" class="form-control h-100" required>
   </div>
   <div class="col-lg-2 col-md-12 col-sm-12 col-12 pt-1">
     <button class="btn btn-outline-success w-100" name="modular_add_category" value="Y">
      <span class="dashicons dashicons-yes"></span>
    </button>
  </div>
</form>
<div class="row">
  <div class="col h5 text-uppercase p-3 mb-2 bg-light">
   Категории:
 </div>
</div>
<?php foreach ($modular_categories_arr as $key => $value): ?>
  <div class="row">
   <div class="col-lg-8 col-md-12 col-sm-12 col-12">
    <div class="h5"><?php echo $value->name; ?></div>
  </div>
  <div class="col-lg-2 col-md-6 col-sm-6 col-6">
    <a href="?page=<?php echo $_GET['page'];?>&category_edit=<?php echo $value->cat_ID;?>"
     class="btn btn-sm btn-outline-primary w-75"	title="Редактировать">
     <span class="dashicons dashicons-edit-page"></span>
   </a>
 </div>
 <div class="col-lg-2 col-md-6 col-sm-6 col-6">
  <form action="" method="post" title="Удалить">
    <button name="modular_delete_category" value="<?php echo $value->cat_ID;?>"
      class="btn btn-sm btn-outline-danger w-75">
      <span class="dashicons dashicons-trash"></span>
    </button>
  </form>
</div>
</div>
<hr>
<?php endforeach ?>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 col-12">
 <form method="post" action="" class="row m-1 pb-3 mb-5 border">
  <div class="col-12">
   Добавить подкатегорию:
 </div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-12 pt-1">
   <input type="text" name="cat_name" class="form-control h-100" required>
 </div>
 <div class="col-12">В категорию:</div>
 <div class="col-lg-10 col-md-12 col-sm-12 col-12 pt-1">
   <select name="category_parent" class="form-select h-100 w-100">
    <?php foreach ($modular_categories_arr as $key => $value): ?>
     <option value="<?php echo $value->cat_ID ?>"
      <?php if ($value->cat_ID == $modular_current_category): ?>
        selected="selected"
      <?php endif ?>
      >
      <?php echo $value->name; ?>
    </option>
  <?php endforeach ?>
</select>
</div>
<div class="col-lg-2 col-md-12 col-sm-12 col-12 pt-1">
 <button class="btn btn-outline-success w-100" name="modular_add_category" value="Y">
  <span class="dashicons dashicons-yes"></span>
</button>
</div>
</form>
<div class="row">
  <div class="col h5 text-uppercase p-3 mb-2 bg-light">
   Подкатегории в категории:
 </div>
 <form action="" method="get" class="row pb-5" id="admin_modular-subcategory_filter">
   <div class="col-12">
    <input type="hidden" name="page" value="<?php echo $_GET['page'] ?>">
    <select name="current_category" class="form-select h-100">
     <?php foreach ($modular_categories_arr as $key => $value): ?>
      <option value="<?php echo $value->cat_ID ?>"
       <?php if ($value->cat_ID == $modular_current_category): ?>
        selected="selected"
      <?php endif ?>
      >
      <?php echo $value->name; ?>
    </option>
  <?php endforeach ?>
</select>
</div>
</form>

<?php foreach ($modular_subcategories_arr as $key => $value): ?>
 <div class="row pb-2">
  <div class="col-lg-8 col-md-12 col-sm-12 col-12">
   <div class="h5"><?php echo $value->name; ?></div>
 </div> 
 <div class="col-lg-2 col-md-6 col-sm-6 col-6">
   <a href="?page=<?php echo $_GET['page'];?>&category_edit=<?php echo $value->cat_ID;?>"
    class="btn btn-sm btn-outline-primary w-75"	title="Редактировать">
    <span class="dashicons dashicons-edit-page"></span>
  </a>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-6">
 <form action="" method="post" title="Удалить">
  <button name="modular_delete_category" value="<?php echo $value->cat_ID;?>"
   class="btn btn-sm btn-outline-danger w-75">
   <span class="dashicons dashicons-trash"></span>
 </button>
</form>
</div>
</div>
<hr>
<?php endforeach ?>

</div>
</div>
</div>
</div>

<script>
	$(function () {
		$('#admin_modular-subcategory_filter').find('select').change(function () {
			$('#admin_modular-subcategory_filter').trigger('submit');
		});
	});
</script>
<?php endif ?>