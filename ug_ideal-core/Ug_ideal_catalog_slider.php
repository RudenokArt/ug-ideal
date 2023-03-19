<?php 

/**
 * 
 */
class Ug_ideal_catalog_slider {

  function __construct() {

    $this->alert = [
      'visible' => false,
      'color' => 'success',
      'text' => '',
    ];

    $this->slider_category = get_category_by_slug('catalog_slider');

    if (isset($_POST['delete_slider_image'])) {
      $this->deleteSliderPostsImage();
    }

    if (isset($_POST['add_sleder_image']) and $_POST['add_sleder_image'] == 'Y') {
      $this->addSliderPostImage();
    }

    $this->posts_arr = $this->getPostsArr();
    $this->check_posts_arr = $this->getCheckPostsArr();
    $this->slider_list = $this->getSliderList();
    if (isset($_GET['category'])) {
      $this->current_category = $this->getCurrentCategory();
      $this->images_list = $this->getImagesList();
    } else {
      $this->categories_list = $this->getCategoriesList();
    }


  }

  function getSliderList () {
    global $wpdb;
    $str = '';
    foreach ($this->check_posts_arr as $key => $value) {
      $str = $str.$value;
      if ($key < (sizeof($this->check_posts_arr) - 1)) {
        $str = $str.',';
      }
    }
    return $src_arr = $wpdb->get_results(
      'SELECT `id`, `gallery_id`, `slug`, `alt`, `thumb_url`
      FROM `wp_bwg_image`
      WHERE `id` IN ('.$str.')'
    );
  }

  function deleteSliderPostsImage () {
    $post = get_posts(['name' => 'catalog_slider_'.$_POST['delete_slider_image']])[0];
    $delete = wp_delete_post($post->ID, true);
    if ($delete) {
      $this->alert['text'] = 'Запись удалена из базы данных!';
      $this->alert['visible'] = true;
    }
  }

  function getCheckPostsArr () {
    foreach ($this->posts_arr as $key => $value) {
      $arr[$key] = explode('catalog_slider_', $value->post_name)[1]; 
    }
    return $arr;
  }

  function addSliderPostImage () {
    foreach ($_POST['images_arr'] as $key => $value) {
      if (isset($value['id'])) {
        wp_insert_post([
          'post_title' => $value['slug'],
          'post_name' => 'catalog_slider_'.$value['id'],
          'post_category' => [$this->slider_category->cat_ID],
          'post_status' => 'publish'
        ]);
      }
    }
    $this->alert['text'] = 'Запись добавлена в базу данных!';
    $this->alert['visible'] = true;
  }

  function getPostsArr () {
    return get_posts([
      'numberposts' => 0,
      'category' => $this->slider_category->cat_ID,
    ]);
  }

  function getCurrentCategory () {
    global $wpdb;
    return $wpdb->get_results(
      'SELECT `id`, `name`, `preview_image`, `random_preview_image`
      FROM `wp_bwg_gallery` WHERE `id`="'.$_GET['category'].'"'
    )[0];
  }

  function getImagesList () {
    global $wpdb;
    $src_arr = $wpdb->get_results(
      'SELECT `id`, `gallery_id`, `slug`, `alt`, `thumb_url`
      FROM `wp_bwg_image`
      WHERE `gallery_id`="'.$_GET['category'].'"'
    );
    foreach ($src_arr as $key => $value) {
      if (!in_array($value->id, $this->check_posts_arr)) {
        $arr[] = $value;
      } 
    }
    return $arr;
  }

  function getCategoriesList () {
    global $wpdb;
    return $wpdb->get_results(
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

?>