<?php

/*
Template Name: ug_ideal-catalog
*/

$categories_list = $wpdb->get_results(
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

if (isset($_GET['search'])) {
  $images_list = $wpdb->get_results(
    'SELECT *
    FROM `wp_bwg_image`
    WHERE `alt` LIKE "%'.$_GET['search'].'%"'
  );
}


if (isset($_GET['category'])) {
  $images_list = $wpdb->get_results(
    'SELECT *
    FROM `wp_bwg_image`
    WHERE `gallery_id`="'.$_GET['category'].'"'
  );
  
  $current_category = $wpdb->get_results(
    'SELECT `id`, `name`, `preview_image`, `random_preview_image`
    FROM `wp_bwg_gallery` WHERE `id`="'.$_GET['category'].'"'
  )[0];
}

include_once 'ug_ideal-includes/header.php';
?>


<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/ug_ideal-assets/css/catalog.css">
<div class="container pt-5 ug_ideal-galery">
  <div class="row pt-5">
    <?php include_once 'ug_ideal-includes/catalog-slider.php'; ?>
  </div>
  <div class="row pt-5 pb-5">
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <?php include_once 'ug_ideal-includes/breadcrumb.php'; ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <?php include_once 'ug_ideal-includes/search-form.php'; ?>
    </div>
  </div>
  <?php 
  
  if (isset($_GET['category']) or isset($_GET['search'])) {
    include_once 'ug_ideal-includes/catalog-images-view.php';
  } else {
    include_once 'ug_ideal-includes/catalog-categories-view.php'; 
  }

  ?>
</div>
<?php get_footer(); ?>