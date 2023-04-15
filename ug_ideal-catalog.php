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

 $(function () {
    $('#ug_ideal-catalog_slider').slick({
      dots: false,
      infinite: true,
      arrows: true,
      speed: 500,
      slidesToShow: 5, 
      slidesToScroll: 1,
      responsive: [
      {
        breakpoint: 960,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 570,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
      ]
    });
    sliderImagesRotation();
    $('#ug_ideal-catalog_slider')
    .on('afterChange', function(event, slick, currentSlide){
      sliderImagesRotation();
    });
  });

  function sliderImagesRotation () {

    var sliderList = $('.ug_ideal-catalog_slider-item.slick-active');

    if (sliderList.length == 5) {
      $(sliderList[0]).find('img').css({
        'transform': 'perspective(1000px) rotateY(45deg)',
        'transition-duration': '0.5s',
      });
      $(sliderList[1]).find('img').css({
        'transform': 'perspective(1000px) rotateY(30deg)',
        'transition-duration': '0.5s',
      });
      $(sliderList[2]).find('img').css({
        'transform': 'perspective(1000px) rotateY(0deg)',
        'transition-duration': '0.5s',
      });
      $(sliderList[3]).find('img').css({
        'transform': 'perspective(1000px) rotateY(-30deg)',
        'transition-duration': '0.5s',
      });
      $(sliderList[4]).find('img').css({
        'transform': 'perspective(1000px) rotateY(-45deg)',
        'transition-duration': '0.5s',
      });
    }

    if (sliderList.length == 3) {
      $(sliderList[2]).find('img').css({
        'transform': 'perspective(1000px) rotateY(45deg)',
        'transition-duration': '0.5s',
      });
      $(sliderList[1]).find('img').css({
        'transform': 'perspective(1000px) rotateY(0deg)',
        'transition-duration': '0.5s',
      });
      $(sliderList[0]).find('img').css({
        'transform': 'perspective(1000px) rotateY(-45deg)',
        'transition-duration': '0.5s',
      });
    }

  }

</script>

<?php get_footer(); ?>