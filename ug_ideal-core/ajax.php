<?php 
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

// Показ ошибок
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (isset($_GET['ya_market'])) {
  include_once 'YandexMarket.php';
}

if (isset($_GET['modular_order_image'])) {
  include_once 'ModularOrderImage.php';
}
if (isset($_GET['wallpaper_order_image'])) {
  include_once 'WallpaperOrderImage.php';
}

if (isset($_GET['get_favorite_list'])) {
  $str = $_GET['get_favorite_list'];
  $str = str_replace('\\', '', $str);
  $arr = json_decode($str);
  $sql_in = implode(',', $arr);
  $arrResult = $wpdb->get_results(
    'SELECT  
    -- *
    `wp_bwg_image`.`id`,
    `wp_bwg_image`.`alt`,
    `wp_bwg_image`.`filename`,
    `wp_bwg_image`.`filetype`,
    `wp_bwg_image`.`image_url`,
    `wp_bwg_image`.`thumb_url`,
    `wp_bwg_gallery`.`name`
    FROM `wp_bwg_image`
    JOIN `wp_bwg_gallery` ON `wp_bwg_image`.`gallery_id`=`wp_bwg_gallery`.`id`
    WHERE `wp_bwg_image`.`id` IN ('.$sql_in.')'
  );
  $strResult = json_encode($arrResult, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  echo $strResult;
}

?>