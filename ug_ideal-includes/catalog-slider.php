<?php 
include_once $theme_path.'/ug_ideal-core/Ug_ideal_catalog_slider.php';
$catalog_slider = new Ug_ideal_catalog_slider();
?>


<div class="h2 text-center text-secondary pb-5">Последние обновления:</div>
<div id="ug_ideal-catalog_slider" class="col-12 ug_ideal-catalog_slider">
  <?php foreach ($catalog_slider->slider_list as $key => $value): ?>
    <div v-on:click="popUpShow('<?php echo $photo_galery_url.$value->thumb_url;?>', '<?php echo $value->id;?>')" class="ug_ideal-catalog_slider-item">
      <img src="<?php echo $photo_galery_url . $value->thumb_url; ?>">
    </div>
  <?php endforeach ?>
</div> 



