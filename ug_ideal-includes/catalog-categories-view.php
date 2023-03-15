<div class="row">
    <?php foreach ($categories_list as $key => $value): ?>
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 ug_ideal-galery-category-wrapper">
        <a href="?category=<?php echo $value->id;?>"
          <?php if ($value->preview_image): ?>
            style="background-image: url(<?php echo $photo_galery_url.$value->preview_image;?>)"
          <?php else: ?>
            style="background-image: url(<?php echo $photo_galery_url.$value->random_preview_image;?>);"
          <?php endif ?> 
          class="ug_ideal-galery-category text-center">
          <span class="h3">
            <?php echo $value->name; ?>
          </span>
        </a>
      </div>
    <?php endforeach ?>
  </div>

<?php include_once 'favorite-counter.php' ?>