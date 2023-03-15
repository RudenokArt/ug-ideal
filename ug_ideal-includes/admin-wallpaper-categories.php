<?php $GLOBALS['admin_current_gallery'] = 'wallpaper'; ?>

<?php include_once __DIR__.'/admin-header.php'; ?>
<?php if (isset($_GET['category_edit'])): ?>
  <?php include_once 'admin-modular-category-edit.php'; ?>
<?php elseif(isset($_GET['category_content'])): ?>
  <?php include_once 'admin-modular-category-content.php' ?>
<?php else: ?>
  <?php include_once 'admin-modular-categories.php'; ?>
<?php endif; ?>

