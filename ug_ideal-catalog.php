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
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<div class="container pt-5 ug_ideal-galery"  id="imagesView">
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

<?php include_once 'ug_ideal-includes/catalog-images-popup.php' ?>

  <a href="/favorite/" class="ug_ideal-favorite_counter">
    <i class="fa fa-star" aria-hidden="true"></i>
    <hr>
    {{favoriteCounter}} 
  </a>


</div>



<script>
  new Vue({
    el: '#imagesView',
    data: {
      favoriteCounter: 0,
      popUpImageId: '',
      popUpImageUrl: '',
      popUpVisible: false,
      popUpExpand: false,
      favoriteAddImage: 'add_to_favorite',
      favoriteAddStarIcon: false,
    },

    methods: {

      popUpShow: function (image_url, image_id) {
        this.popUpImageUrl = image_url;   
        this.popUpImageId = image_id;
        var arr = JSON.parse(localStorage.getItem('ug_ideal_favorite'));
        if (arr.includes(image_id)) {
          this.favoriteAddStarIcon = true;
        } else {
          this.favoriteAddStarIcon = false;
        }
        this.popUpVisible = true;
      },

      removeFromFavorite: function () {
        var arr = JSON.parse(localStorage.getItem('ug_ideal_favorite'));
        newArray = [];
        for (var i = 0; i < arr.length; i++) {
          if (arr[i] != this.popUpImageId) {
            newArray.push(arr[i]);
          }
        }
        this.favoriteAddStarIcon = false;
        this.favoriteCounter = newArray.length;
        localStorage.setItem('ug_ideal_favorite', JSON.stringify(newArray));
      },

      addToFavorite: function () {
        this.favoriteAddImage = 'add_to_favorite-active';
        var thisVue = this;
        setTimeout(function () {
          thisVue.favoriteAddImage = 'add_to_favorite';
          var arr = JSON.parse(localStorage.getItem('ug_ideal_favorite'));
          arr.push(thisVue.popUpImageId);
          localStorage.setItem('ug_ideal_favorite', JSON.stringify(arr));
          thisVue.favoriteCounter = arr.length;
          thisVue.favoriteAddStarIcon = true;
        }, 100);
      },
    },

    mounted: function () {
      if (localStorage.getItem('ug_ideal_favorite')) {
        this.favoriteCounter = JSON.parse(localStorage.getItem('ug_ideal_favorite')).length;
      } else {
        localStorage.setItem('ug_ideal_favorite', JSON.stringify([]));
        this.favoriteCounter = 0;
      }
    },

    computed: {

      popUpImageBackground: function () {
        return {
          'background-image': 'url(' + this.popUpImageUrl + ')',
        };
      }
    }
  });
</script>

<?php get_footer(); ?>