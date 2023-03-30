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

<script>
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

