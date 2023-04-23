<?php

$rotation_arr = [
	'0/360' => 0,
	'90' => 90,
	'180' => 180,
	'270' => 270,
];

$reflection_arr = [
	['scale(1, 1)', 'Нет'],
	['scale(-1, 1)', 'По горизонтали'],
	['scale(1, -1)', 'По вертикали'],
];

$image = $wpdb->get_results(
	'SELECT * FROM `wp_bwg_image`	WHERE `id`='.$_GET['id']
)[0];

if (isset($_FILES['customer_image'])) {
  $customer_image_ext = pathinfo($_FILES['customer_image']['name'])['extension'];
  $customer_image_url = '/customer_image.'.$customer_image_ext;
  move_uploaded_file(
    $_FILES['customer_image']['tmp_name'],
    $_SERVER['DOCUMENT_ROOT'].$photo_galery_url.$customer_image_url
  );
  $image->id = 'customer_image';
  $image->slug = 'customer_image';
  $image->filename = 'customer_image';
  $image->image_url = $customer_image_url;
  $image->thumb_url = $customer_image_url;
  $image->filetype = $customer_image_ext;
  $image->alt = 'customer_image';
}


$image->description = trim($image->description);
$image_json = json_encode($image, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

$templates_arr = $wpdb->get_results(
	'SELECT * FROM `wp_bwg_gallery`
	JOIN `wp_bwg_image` ON `wp_bwg_image`.`gallery_id`=`wp_bwg_gallery`.`id`
	WHERE `wp_bwg_gallery`.`slug`="modular_templates"'
);
$templates_json = json_encode($templates_arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

$interior_arr = $wpdb->get_results(
	'SELECT * FROM `wp_bwg_gallery`
	JOIN `wp_bwg_image` ON `wp_bwg_image`.`gallery_id`=`wp_bwg_gallery`.`id`
	WHERE `wp_bwg_gallery`.`slug`="interiors"'
);

$template_size_arr = get_posts([
	'category_name' => 'modular_template_size',
	'orderby' => 'title',
	'order' => 'ASC',
  'numberposts' => 0,
]);

$template_mat_arr = get_posts([
	'category_name' => 'modular_template_mat',
	'orderby' => 'title',
	'order' => 'ASC',
  'numberposts' => 0,
]);

$template_price_arr = get_posts([
	'category_name' => 'modular_template_price',
	'orderby' => 'title',
	'order' => 'ASC',
  'numberposts' => 0,
]);

foreach ($template_price_arr as $key => $value) {
  $template_price_arr[$key]->post_content = json_decode($template_price_arr[$key]->post_content);
}

$modular_discount = 0;

?>

<link rel="stylesheet" href="<?php echo $theme_url;?>/ug_ideal-assets/css/modular-detail.css">

<div class="container pt-5 pb-5 modular_detail" id="modular_detail">
  <div class="row pt-5 pb-5">
    <div class="col">
      <a href="<?php echo $_SESSION['back_page_url'];?>" class="btn btn-outline-light border w-100">
        <div class="content_color text_hover_color w-100">
          <i class="fa fa-chevron-left" aria-hidden="true"></i>
          Вернуться в галерею
        </div>
      </a>
    </div>
  </div>

  <div class="row">

    <div class="col-lg-6 col-md-6 col-sm-12 col-12">

      <div class="row justify-content-center pt-2">
        <div id="modular_detail-template_slider" class="col-lg-10 col-md-9 col-sm-8 col-8 modular_detail-template_slider">
         <?php foreach ($templates_arr as $key => $value): ?>
          <div v-on:click="SetCurrentTemplate(<?php echo $key;?>)" class="theme_color">
           <img src="<?php echo $photo_galery_url.$value->image_url; ?>" class="w-100">
         </div>            
       <?php endforeach ?>
     </div>
   </div>

   <div class="row pt-2">
    <div class="col-12">
     <div class="border modular_detail-template_wrapper">
      <img 
      v-bind:style="imageStyle"
      v-bind:src="`<?php echo $photo_galery_url;?>${image.image_url}<?php echo '?v='.time(); ?>`"
      class="modular_detail-image">
      <img v-bind:src="`<?php echo $photo_galery_url;?>${currentTemplate.image_url}`"
      class="modular_detail-template">
      <div class="modular_detail-favorite-icon">
        <a href="#" v-if="!favoriteAddStarIcon" v-on:click.prevent="addToFavorite" title="Добавить в избранное">
          <i class="fa fa-star-o" aria-hidden="true"></i>
        </a>
        <a href="#" v-if="favoriteAddStarIcon" v-on:click.prevent="removeFromFavorite" title="Удалить из избранного">
          <i class="fa fa-star" aria-hidden="true"></i>
        </a>
      </div>
    </div>					
  </div>
</div>

</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-12">

 <div class="p-2 row">
  <div class="col-2 text-end content_color">
   <i class="fa fa-arrows-v" aria-hidden="true"></i>
 </div>
 <div class="col-10">
   <input type="range" class="form-range" v-model="imagePositionTop" min="-50" max="50">
 </div>
</div>

<div class="p-2 row">
  <div class="col-2 text-end content_color">
   <i class="fa fa-arrows-h" aria-hidden="true"></i>
 </div>
 <div class="col-10">
   <input type="range" class="form-range" v-model="imagePositionLeft" min="-50" max="50">
 </div>
</div>

<div class="p-2 row">
  <div class="col-2 text-end content_color">
   <i class="fa fa-expand" aria-hidden="true"></i>
 </div>
 <div class="col-10">
   <input type="range" class="form-range" v-model="imagePositionWidth" min="50" max="150">
 </div>
</div>

<hr>
<div class="pt-2 row">
  <div class="col text-end content_color">
   <i class="fa fa-repeat" aria-hidden="true"></i>
 </div>
 <?php foreach ($rotation_arr as $key => $value): ?>
   <label class="col content_color" style="white-space: nowrap;">
    <input v-model="imageRotate" value="<?php echo $value; ?>" type="radio" name="rotation" class="form-check-input">
    <?php echo $key; ?><sup>0</sup>
  </label>					
<?php endforeach ?>
</div>

<hr>
<div class="pt-2 row justify-content-center">
  <div class="col-5 text-uppercase content_color">
   <b>Зеркало:</b>
 </div>
 <?php foreach ($reflection_arr as $key => $value): ?>
   <label class="col-5 p-1 content_color">
    <input type="radio" v-model="imageReflection" value="<?php echo $value[0]; ?>" name="reflection" class="form-check-input">
    <?php echo $value[1] ?>
  </label>
<?php endforeach ?>
</div>
<hr>

<div class="row">
  <div class="col-6">
   <span class="content_color">Размер:</span>
   <select class="form-select" v-model="templateSize">
    <template v-for="(item, index) in sizeArr" >
     <option v-bind:value="index" v-if="templatePrice[item.ID]">
      {{item.post_title}}
    </option>
  </template>			
</select>
</div>
<div class="col-6">
 <span class="content_color">Материал:</span>
 <select class="form-select" v-model="templateMat">
  <template v-for="(item, index) in matArr" >
   <option v-bind:value="index">
    {{item.post_title}}
  </option>
</template>			
</select>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 col-12 pt-2">
 <div class="alert alert-light border">
  <span class="content_color">
   СТОИМОСТЬ:
   {{totalPrice}} руб.
 </span>
</div>

</div>
<?php if ($modular_discount): ?>          
 <div class="col-lg-6 col-md-6 col-sm-12 col-12 pt-2">
  <div class="alert alert-info">
   <span>СКИДКА: {{discount}} %</span>
 </div>
</div>
<div class="col-12">
 <div class="alert alert-info">
  <span>СТОИМОСТЬ СО СКИДКОЙ: {{totalDiscountPrice}} руб.</span>
</div>
</div>
<?php endif ?>
</div>

<div class="row">
  <div class="col-6">
   <button v-on:click="PopupShow('modular_detail-interior_popup')"
   class="btn btn-outline-light border w-100">
   <div class="content_color text_hover_color w-100">
    <i class="fa fa-camera" aria-hidden="true"></i>
    Просмотр в интерьере
  </div>  
</button>
</div>

<div class="col-6">
  <button v-on:click="OrderImage('download')" class="btn btn-outline-light border w-100">
    <div class="content_color text_hover_color w-100">
     <i class="fa fa-cloud-download" aria-hidden="true"></i>
     Скачать изображение
   </div>  
 </button>
</div>

<div class="col-6 pt-2">
  <button v-on:click="PopupShow('modular_detail-mail_popup')" class="btn btn-outline-light border w-100">
    <div class="content_color text_hover_color w-100">
     <i class="fa fa-envelope-o" aria-hidden="true"></i>
     Получить на почту
   </div>
 </button>
</div>

<div class="col-6 pt-2">
  <button v-on:click="PopupShow('modular_detail-order_popup')" class="btn btn-outline-light border w-100">
    <div  class="content_color text_hover_color w-100">
       <i class="fa fa-handshake-o" aria-hidden="true"></i>
      Оформить заказ
    </div>
  </button>
</div>

<div class="row">
  <form action="" method="post" enctype="multipart/form-data" class="col-6 pt-2" id="customerImage">
    <label class="btn btn-outline-light border w-100">
      <div class="content_color text_hover_color w-100">
        <i class="fa fa-cloud-upload" aria-hidden="true"></i>
      Загрузить свое фото
      <input type="file" class="btn btn-outline-info" name="customer_image" v-on:change="CustomerImageUpload">
      </div>
    </label>
  </form>
</div>

</div>
</div>
</div>

<div class="modular_detail-popup_wrapper" id="modular_detail-order_popup">
  <div class="modular_detail-popup">
    <div class="text-end">
      <button v-on:click="PopupHide('modular_detail-order_popup')" class="m-1 btn btn-outline-danger"> 
        <i class="fa fa-times" aria-hidden="true"></i>
      </button>
    </div>
    <div class="card m-2 p-2">
      <form v-on:submit.prevent="OrderImage('order')" action="" method="post">
        ФИО:
        <input v-model="customerFio" type="text" required class="form-control mb-3">
        Email:
        <input v-model="customerMail" type="email" required class="form-control mb-3">
        тел:
        <input v-model="customerPhone" type="text" required class="form-control mb-3">
        <button class="btn btn-outline-success">
          <i class="fa fa-envelope-o" aria-hidden="true"></i>
          Отправить
        </button>
      </form>

    </div>
  </div>
</div>

<div class="modular_detail-popup_wrapper" id="modular_detail-alert_popup">
	<div class="modular_detail-popup">
		<div class="text-end">
			<button v-on:click="PopupHide('modular_detail-alert_popup')" class="m-1 btn btn-outline-danger"> 
				<i class="fa fa-times" aria-hidden="true"></i>
			</button>
		</div>
		<div class="card m-3 p-3 h5">
			{{alert}}
		</div>
	</div>
</div>

<div class="modular_detail-popup_wrapper" id="modular_detail-mail_popup">
	<div class="modular_detail-popup">
		<div class="text-end">
			<button v-on:click="PopupHide('modular_detail-mail_popup')" class="m-1 btn btn-outline-danger"> 
				<i class="fa fa-times" aria-hidden="true"></i>
			</button>
		</div>
		<div class="card m-2 p-2">
			Email:
			<form v-on:submit.prevent="OrderImage('mail')" action="" method="post">
				<input v-model='customerMail' type="email" required class="form-control mb-3">
       <button class="btn btn-outline-success">
        <i class="fa fa-envelope-o" aria-hidden="true"></i>
        Отправить
      </button>
    </form>

  </div>
</div>
</div>

<div class="modular_detail-popup_wrapper" id="modular_detail-interior_popup">
	<div class="modular_detail-popup">
		<div class="text-end">
			<button v-on:click="PopupHide('modular_detail-interior_popup')" class="m-1 btn btn-outline-danger"> 
				<i class="fa fa-times" aria-hidden="true"></i>
			</button>
		</div>

		<div class="modular_detail-interior_popup-inner">
			<div class="modular_detail-interior-image_wrapper">
				<img
				v-bind:src="`<?php echo $photo_galery_url;?>${image.image_url}`"
				v-bind:style="imageStyle"
				class="modular_detail-interior-image">
				<img class="modular_detail-interior-template" v-bind:src="`<?php echo $photo_galery_url;?>${currentTemplate.image_url}`">
			</div>
			<div class="modular_detail-interior_slider-wrapper">
				<div class="modular_detail-interior_slider" id="modular_detail-interior_slider">
					<?php foreach ($interior_arr as $key => $value): ?>
						<img src="<?php echo $photo_galery_url.$value->image_url; ?>" alt="">
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</div>

<a href="/favorite/" class="ug_ideal-favorite_counter">
  <i class="fa fa-star" aria-hidden="true"></i>
  <hr>
  {{favoriteCounter}} 
</a>

<div v-bind:class="favoriteAddImage">
  <img class="add_to_favorite_image" src="<?php echo get_stylesheet_directory_uri();?>/ug_ideal-assets/img/add_to_favorite.png" alt="">
</div>

</div>

<?php include_once 'preloader.php'; ?>
<script>
	$('.ug_ideal-preloader-wrapper').css({'display': 'none'});

	new Vue ({
		el: '#modular_detail',

		data: {
			theme_url: '<?php echo get_stylesheet_directory_uri();?>',
			imageJson:'<?php echo $image_json; ?>',
			templatesJson: '<?php echo $templates_json; ?>',
			currentTemplateIndex: 0,
			imagePositionTop: 0,
			imagePositionLeft: 0,
			imagePositionWidth: 100,
			imageRotate: 0,
			imageReflection: 'scale(1, 1)',
			sizeJson: '<?php echo json_encode($template_size_arr); ?>',
			templateSize: 0,
			matJson: '<?php echo json_encode($template_mat_arr); ?>',
			templateMat: 0,
			priceJson: '<?php echo json_encode($template_price_arr); ?>',
			discount: '<?php echo $modular_discount; ?>',
			alert: '',
			customerMail: '',
      customerPhone: '',
      customerFio: '',

      favoriteCounter: 0,
      popUpImageId: '<?php echo $_GET["id"]; ?>',
      favoriteAddImage: 'add_to_favorite',
      favoriteAddStarIcon: false,
    },

    mounted: function () {
      if (localStorage.getItem('ug_ideal_favorite')) {
        this.favoriteCounter = JSON.parse(localStorage.getItem('ug_ideal_favorite')).length;
      } else {
        localStorage.setItem('ug_ideal_favorite', JSON.stringify([]));
        this.favoriteCounter = 0;
      }
      var arr = JSON.parse(localStorage.getItem('ug_ideal_favorite'));
      if (arr.includes(this.popUpImageId)) {
        this.favoriteAddStarIcon = true;
      } else {
        this.favoriteAddStarIcon = false;
      }
    },

    methods: {

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

      CustomerImageUpload: function () {
        $('#customerImage')[0].submit();
      },

      OrderImage: async function (action) {
        $('.ug_ideal-preloader-wrapper').css({'display': 'flex'});
        var ajax_url = this.theme_url + 
        '/ug_ideal-core/ajax.php?modular_order_image=Y'+
        '&folder=<?php echo $photo_galery_url ?>' +
        '&image=' + this.imageJson +
        '&template=' + JSON.stringify(this.currentTemplate) + 
        '&top=' + this.imagePositionTop +
        '&left=' + this.imagePositionLeft +
        '&width=' + this.imagePositionWidth + 
        '&rotation=' + this.imageRotate +
        '&reflection=' + this.imageReflection;
        var img = await $.get(ajax_url);
        var order = await this.OrderPDF(action);
        if (action == 'download') {
         window.open(this.theme_url + '/ug_ideal-libs/dompdf/modular_order.pdf?v='+Math.random(), '_blank');
       }
       if (action == 'mail') {
         this.PopupHide('modular_detail-mail_popup');
         var mail = await this.OrderMail();
         this.alert = 'Эскиз отправлен на указанную почту.';
         this.PopupShow('modular_detail-alert_popup');
       }
       if (action == 'order') {
        this.PopupHide('modular_detail-order_popup');

        var place = await this.OrderPlace();
        console.log(place);
        this.alert = 'Ваш заказ принят. Наш менеджер свяжется с вами';
        this.PopupShow('modular_detail-alert_popup');
      }
      $('.ug_ideal-preloader-wrapper').css({'display': 'none'});
    },

    OrderPlace: async function () {
      var mailData = new URLSearchParams();
      mailData.set('customer_mail', this.customerMail);
      mailData.set('order_mail', 'Y');
      mailData.set('subject', 'Заказ модульной картины');
      mailData.set('body', 'Юг-идеал. Заказ модульной картины');
      mailData.set('file_path', '<?php echo get_stylesheet_directory(); ?>/ug_ideal-libs/dompdf/modular_order.pdf');
      var order = await $.get(this.theme_url + '/ug_ideal-libs/PHPMailer/?' + mailData.toString());
      return true;
    },
    // test@mail.ru

    OrderMail: async function () {
      var mailData = new URLSearchParams();
      mailData.set('customer_mail', this.customerMail);
      mailData.set('subject', 'Эскиз модульной картины');
      mailData.set('body', 'Юг-идеал. Эскиз модульной картины');
      mailData.set('file_path', '<?php echo get_stylesheet_directory(); ?>/ug_ideal-libs/dompdf/modular_order.pdf');
      var order = await $.get(this.theme_url + '/ug_ideal-libs/PHPMailer/?' + mailData.toString());
      return true;
    },

    OrderPDF: async function (action) {
      var ajax_url = this.theme_url + 
      '/ug_ideal-libs/dompdf/modular_order.php' +
      '?imageName=' + this.image.slug + 
      '&material=' + this.matArr[this.templateMat].post_title +
      '&size=' + this.sizeArr[this.templateSize].post_title +
      '&amount=' + this.totalPrice +
      '&discount=' + this.discount +
      '&total=' + this.totalDiscountPrice +
      '&customer_mail=' + this.customerMail +
      '&customer_phone=' + this.customerPhone +
      '&customer_fio=' + this.customerFio +
      '' +
      '';
      var result = await $.get(ajax_url);
      return result;
    },

    PopupShow: function (popup) {
      $('#'+popup).css({'height':'100vh'});
    },

    PopupHide: function (popup) {
      $('#'+popup).css({'height':'0vh'});
    },

    SetCurrentTemplate: function (index) {
      this.currentTemplateIndex = index;
    },

  },

  computed: {

   imageStyle: function () {
    return {
     'top': this.imagePositionTop + '%',
     'left': this.imagePositionLeft + '%',
     'width': this.imagePositionWidth + '%',
     'max-width': this.imagePositionWidth + '%',
     'transform': 'rotate('+this.imageRotate+'deg) ' + this.imageReflection,
   };
 },

 image: function () {
  return JSON.parse(this.imageJson);
},

templatesArr: function () {
  return JSON.parse(this.templatesJson);
},

currentTemplate: function () {
  return this.templatesArr[this.currentTemplateIndex];
},

sizeArr: function () {
  return JSON.parse(this.sizeJson);
},

matArr: function () {
  return JSON.parse(this.matJson);
},

priceArr: function () {
  return JSON.parse(this.priceJson);
},


templatePrice:function () {
  var price = 0;
  for (var i = 0; i < this.priceArr.length; i++) {
   if (this.priceArr[i].post_name == this.currentTemplate.id) {
    price = this.priceArr[i].post_content;
  }
}
return price;
},

totalPrice: function () {
  return Math.floor(
    this.templatePrice[this.sizeArr[this.templateSize].ID] *
    (this.matArr[this.templateMat].post_content / 100 + 1)
    );
  return Math.floor(
   this.templatePrice *
   (this.sizeArr[this.templateSize].post_content / 100 + 1) *
   (this.matArr[this.templateMat].post_content / 100 + 1)
   );
},

totalDiscountPrice: function () {
  return Math.floor(this.totalPrice * (100-this.discount)/100);
},

}

});

$('#modular_detail-interior_slider').slick();

$('#modular_detail-template_slider').slick({
  dots: true,
  infinite: true,
  speed: 300,
  slidesToShow: 5,
  slidesToScroll: 5,
  responsive: [
  {
   breakpoint: 992,
   settings: {
    slidesToShow: 4,
    slidesToScroll: 4,
    infinite: true,
    dots: true
  }
},
{
 breakpoint: 768,
 settings: {
  slidesToShow: 3,
  slidesToScroll: 3
}
},
{
 breakpoint: 576,
 settings: {
  slidesToShow: 2,
  slidesToScroll: 2,
  dots: false,
}
}
]
});


</script>