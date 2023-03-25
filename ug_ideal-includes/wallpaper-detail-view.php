<?php $wallpaper_detail = new Wallpaper_detail_view($_GET['id']); ?>
<link rel="stylesheet" href="<?php echo $theme_url;?>/ug_ideal-assets/css/wallpaper-detail.css">

<div class="container pt-5 pb-5" id="wallpaper_detail" class="wallpaper_detail">

	<div class="row pt-5 pb-5">
		<div class="col">
			<a href="<?php echo $_SESSION['back_page_url'];?>" class="btn btn-outline-info w-100">
				<i class="fa fa-chevron-left" aria-hidden="true"></i>
				Вернуться в галерею
			</a>
		</div>
	</div>

	<div class="row">

		<div class="col-lg-8 col-md-12 col-sm-12 col-12 p-0 wallpaper-wall_wrapper">
			<div class="wallpaper-wall" id="wallpaper-wall">
        <img  src="<?php echo $photo_galery_url.$wallpaper_detail->image->image_url.'?v='.time();?>"
        v-bind:style="imageStyle" id="wallpaper-image"
        alt="<?php echo $photo_galery_url.$wallpaper_detail->image->image_url; ?>" class="wallpaper-image">
        <div class="wallpaper-wall_height" v-bind:style="wallHeightStyle"></div>
        <div class="wallpaper-wall_height-bottom" v-bind:style="wallHeightStyle"></div>
        <div class="wallpaper-axix_Y" v-bind:style="wallpaperAxixY">
          <span>{{wallHeigh}} см</span>
        </div>
        <div class="wallpaper-wall_width" v-bind:style="wallWidthStyle">

        </div>
        <div class="wallpaper-wall_width-left" v-bind:style="wallWidthStyle"></div>
        <div class="wallpaper-axix_X" v-bind:style="wallpaperAxixX">
          <div class="wallpaper-roll-tape">
            <?php for ($i=0; $i < 10; $i++): ?>
              <div class="wallpaper-roll" v-bind:style="rollWidthStyle"></div>
            <?php endfor; ?>
          </div>
          <span>{{wallWidth}} см</span>
        </div>
      </div>


      <div class="modular_detail-favorite-icon">
        <a href="#" v-if="!favoriteAddStarIcon" v-on:click.prevent="addToFavorite" title="Добавить в избранное" class="h3">
          <i class="fa fa-star-o" aria-hidden="true"></i>
        </a>
        <a href="#" v-if="favoriteAddStarIcon" v-on:click.prevent="removeFromFavorite"title="Удалить из избранного" class="h3">
          <i class="fa fa-star" aria-hidden="true"></i>
        </a>
      </div>

    </div>

    <div class="col-lg-4 col-md-12 col-sm-12 col-12">
     <div class="row">
      <div class="col-6">
       Высота стены (см): 
     </div>
     <div class="col-6">
       <input type="number" v-model="wallHeigh" class="form-control w-50 p-0 text-center" step="1" max="300" min="50">
     </div>
     <div class="col-12">
       <input type="range" class="form-range" max="300" min="50" v-model="wallHeigh">
     </div>
   </div>
   <div class="row">
    <div class="col-6">
     Ширина стены (см): 
   </div>
   <div class="col-6">
     <input type="number" v-model="wallWidth" class="form-control w-50 p-0 text-center" step="1" max="500" min="50">
   </div>
   <div class="col-12">
     <input type="range" class="form-range" max="500" min="50" v-model="wallWidth">
   </div>
 </div>

 <div class="row">
  <div class="col-12">
    <span class="text-info">
      <i class="fa fa-expand" aria-hidden="true"></i>
    </span>
    Масштаб изображения: {{imageWidth}} %
  </div>
  <div class="col-12">
    <input type="range" class="form-range" max="150" min="50" v-model="imageWidth">
  </div>
</div>

<div class="row">
  <div class="col-12">
    <span class="text-info">
      <i class="fa fa-arrows-v" aria-hidden="true"></i>
    </span>
    по вертикали:
  </div>
  <div class="col-12">
    <input type="range" class="form-range" max="50" min="-50" v-model="imageTop">
  </div>
</div>

<div class="row">
  <div class="col-12">
    <span class="text-info">
      <i class="fa fa-arrows-h" aria-hidden="true"></i>
    </span>
    по горизонтали:
  </div>
  <div class="col-12">
    <input type="range" class="form-range" max="50" min="-50" v-model="imageLeft">
  </div>
</div>
<hr>
<div class="row">
  <div class="col-12">
    <span class="text-info">
      <i class="fa fa-repeat" aria-hidden="true"></i>
    </span>
    Поворот:
  </div>
  <?php foreach ($wallpaper_detail->rotation_arr as $key => $value): ?>
   <label class="col" style="white-space: nowrap;">
    <input v-model="imageRotate" value="<?php echo $value; ?>" type="radio" name="rotation" class="form-check-input">
    <?php echo $key; ?><sup>0</sup>
  </label>          
<?php endforeach ?>
</div>
<hr>
<div class="row">
  <div class="col-12">
    Зеркало:
  </div>
  <?php foreach ($wallpaper_detail->reflection_arr as $key => $value): ?>
   <label class="col">
    <input type="radio" v-model="imageReflection" value="<?php echo $value[0]; ?>" name="reflection" class="form-check-input">
    <?php echo $value[1] ?>
  </label>
<?php endforeach ?>
</div>
<hr>

<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-12 col-12">
    Ширина рулона (см):
    <select class="form-select" v-model="currentSize">
      <option v-for="(item, index) in sizeArr" v-bind:value="index">
        {{item.post_title}}
      </option>
    </select>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-12 col-12">
    Выбор фактуры:
    <button v-on:click="PopupShow('texturesPopUp')" class=" btn btn-outline-secondary w-100">
      <span class="row">
        <span class="col-9 text-start">{{texturesArr[currentTexture].slug}}</span>
        <span class="col-3 pt-1"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
      </span>
    </button>
  </div>
</div>

</div>

</div>

<div class="row pt-3">
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="alert alert-info">
      Стоимость: {{priceTotal}} руб
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <button v-on:click="PopupShow('interiorsPopUp')" class=" btn btn-outline-info w-100 mt-1">
      <i class="fa fa-camera" aria-hidden="true"></i>
      Просмотреть в интерьере
    </button>
    <button v-on:click="fileUploadTrigger" class=" btn btn-outline-info w-100 mt-1">
      <i class="fa fa-cloud-upload" aria-hidden="true"></i>
      Загрузить свое фото
    </button>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <button v-on:click="ImageOrder('download')" class=" btn btn-outline-info w-100 mt-1">
      <i class="fa fa-cloud-download" aria-hidden="true"></i>
      Скачать изображение
    </button>
    <button v-on:click.prevent="PopupShow('mailPopup')" class=" btn btn-outline-info w-100 mt-1">
      <i class="fa fa-envelope" aria-hidden="true"></i>
      Получить на почту
    </button>
  </div>


  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <button v-on:click.prevent="PopupShow('orderPopup')" class=" btn btn-outline-info w-100 mt-1">
      <i class="fa fa-handshake-o" aria-hidden="true"></i>
      Оформить заказ
    </button>
  </div>

</div>

<div class="d-none d-lg-none d-md-none d-sm-none">
  <form action="" enctype="multipart/form-data" method="post" id="customer_image_form">
    <input v-on:change="customerImageFormSubmit" type="file" name="customer_image" id="customer_image">
  </form>
</div>



<div class="wallpaper-popup_wrapper m-0 row justify-content-center" id="texturesPopUp">
  <div class="wallpaper-popup col-xxl-4 col-xl-5 col-lg-6 col-md-9 col-sm-11 col-11 mt-5">
    <div class="text-end">
      <a v-on:click.prevent="PopupHide('texturesPopUp')" href="#" class="text-danger h4 p-2">
        <i class="fa fa-times" aria-hidden="true"></i>
      </a>
    </div>
    <div id="texturesPopUp_slider">
      <?php foreach ($wallpaper_detail->textures_arr as $key => $value): ?>
        <div class="textures-popup-slider-item">
          <img
          class="textures-popup-slider-item-img" style="opacity:0;"
          src="<?php echo $photo_galery_url . $wallpaper_detail->image->image_url;?>" alt=""
          >
          <img class="textures-popup-slider-item-texture"
          src="<?php echo $photo_galery_url . $value->image_url; ?>"
          alt="<?php echo $value->slug; ?>"
          >
          <img
          class="textures-popup-slider-item-img"
          src="<?php echo $photo_galery_url . $wallpaper_detail->image->image_url;?>" alt=""
          >
          <div class="text-center textures-popup-slider-item-button w-100 pt-1">
            <button v-on:click="SetCurrentTexture(<?php echo $key;?>)"
              class="w-75 btn btn-success">
              <i class="fa fa-check" aria-hidden="true"></i>
              Выбрать
            </button>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</div>

<div class="wallpaper-popup_wrapper row m-0 justify-content-center" id="interiorsPopUp">
  <div class="wallpaper-popup col-lg-6 col-md-9 col-sm-11 col-11 mt-5">
    <div class="text-end">
      <a v-on:click.prevent="PopupHide('interiorsPopUp')" href="#" class="text-danger h4 p-2">
        <i class="fa fa-times" aria-hidden="true"></i>
      </a>
    </div>
    <div style="background-image: url(<?php echo $photo_galery_url . $wallpaper_detail->image->image_url;?>);"
      id="interiorsPopUp_slider" class="interiorsPopUp_slider">
      <?php foreach ($wallpaper_detail->interior_arr as $key => $value): ?>
       <img src="<?php echo $photo_galery_url . $value->image_url;?>" alt="<?php echo $value->slug; ?>">
     <?php endforeach ?>
   </div>
 </div>
</div>

<div class="wallpaper-popup_wrapper" id="mailPopup">
  <div class="wallpaper-popup">
   <div class="text-end">
    <a v-on:click.prevent="PopupHide('mailPopup')" href="#" class="text-danger h4 p-2">
      <i class="fa fa-times" aria-hidden="true"></i>
    </a>
  </div>
  <form v-on:submit.prevent="ImageOrder('email')">
    <div class="h5">Email:</div>
    <div class="pt-3">
      <input type="email" required class="form-control" v-model="customer_mail">
    </div>
    <div class="pt-3">
      <button class="btn btn-lg btn-outline-success w-100">
        <i class="fa fa-envelope" aria-hidden="true"></i>
      </button>
    </div>
  </form>
</div>
</div>

<div class="wallpaper-popup_wrapper" id="orderPopup">
  <div class="wallpaper-popup">
   <div class="text-end">
    <a v-on:click.prevent="PopupHide('orderPopup')" href="#" class="text-danger h4 p-2">
      <i class="fa fa-times" aria-hidden="true"></i>
    </a>
  </div>
  <form v-on:submit.prevent="ImageOrder('order')">
    <div class="h5">Email:</div>
    <div class="pb-3">
      <input type="email" required class="form-control" v-model="customer_mail">
    </div>
    <div class="h5">ФИО:</div>
    <div class="pb-3">
      <input type="text" required class="form-control" v-model="customer_fio">
    </div>
    <div class="h5">тел:</div>
    <div class="pb-3">
      <input type="text" required class="form-control" v-model="customer_phone">
    </div>
    <div class="pt-3">
      <button class="btn btn-lg btn-outline-success w-100">
        <i class="fa fa-envelope" aria-hidden="true"></i>
      </button>
    </div>
  </form>
</div>
</div>

<div class="wallpaper-popup_wrapper" id="alertPopup">
  <div class="wallpaper-popup">
    <div class="text-end">
      <a v-on:click.prevent="PopupHide('alertPopup')" href="#" class="text-danger h4 p-2">
        <i class="fa fa-times" aria-hidden="true"></i>
      </a>
    </div>
    <div class="p-5 h5">
      {{alert_text}}
    </div>
  </div>
</div>

<a href="/favorite/" class="ug_ideal-favorite_counter">
  <i class="fa fa-star" aria-hidden="true"></i>
  <hr>
  {{favoriteCounter}} 
</a>

<div v-bind:class="favoriteAddImage">
  <img src="<?php echo get_stylesheet_directory_uri();?>/ug_ideal-assets/img/add_to_favorite.png"
  alt="" class="add_to_favorite_image">
</div>

<?php include_once 'preloader.php'; ?>

<a href="<?php echo $theme_url;?>/ug_ideal-libs/dompdf/wallpaper_order.pdf" target="_blank"></a>

</div>


<!-- 
<br>
http://cx57370-wordpress.tw1.ru/wp-content/themes/generatepress/ug_ideal-libs/dompdf/wallpaper_order.pdf
<br>
http://cx57370-wordpress.tw1.ru/wp-content/themes/generatepress/ug_ideal-core/order_image.jpg
-->
<script>

	new Vue ({

		el: '#wallpaper_detail',

		data: {
			wallHeigh: 300,
			wallWidth: 500,
			koff: 0.6,
      imageWidth: 100,
      imageTop: 0,
      imageLeft: 0,
      imageRotate: 0,
      imageReflection: 'scale(1, 1)', 
      sizeArrJson: '<?php echo $wallpaper_detail->size_json; ?>',
      currentSize: 0,
      texturesArrJson: '<?php echo trim($wallpaper_detail->textures_json); ?>',
      currentTexture: 0,
      priceArrJson: '<?php echo $wallpaper_detail->wallpaper_json; ?>',
      theme_url: '<?php echo get_stylesheet_directory_uri();?>',
      imageJson: '<?php echo $wallpaper_detail->image_json; ?>',
      action: 'download',
      customer_mail: '',
      customer_fio: '',
      customer_phone: '',
      alert_text: '',

      favoriteCounter: 0,
      popUpImageId: '<?php echo $_GET["id"]; ?>',
      favoriteAddImage: 'add_to_favorite',
      favoriteAddStarIcon: false,
    },

    watch: {
      imageWidth: function () {
        this.imageVacuumDenied();      
      },
      imageLeft: function () {
        this.imageVacuumDenied();
      },

      imageTop: function () {
        this.imageVacuumDenied();
      },

      wallWidth: function () {
        this.imageVacuumDenied();
        if (this.wallWidth > 500) {
          this.wallWidth = 500;
        }
      },

      wallHeigh: function () {
        this.imageVacuumDenied();
        if (this.wallHeigh > 300) {
          this.wallHeigh = 300;
        }
      },


    },

    mounted: function () {
      $('.ug_ideal-preloader-wrapper').css({'display': 'none'});
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

      imageVacuumDenied: function () {
        if (this.imageWidth < (100-this.wallWidthInt*2)) {
          this.imageWidth = 100-this.wallWidthInt*2;
        } 
        if (this.imageLeft > this.wallWidthInt) {
          this.imageLeft = this.wallWidthInt;
        }
        if (this.imageLeft > this.wallWidthInt) {
          this.imageLeft = this.wallWidthInt;
        }
        if (this.imageLeft < (100 - this.wallWidthInt - this.imageWidth)) {
          this.imageLeft = 100 - this.wallWidthInt - this.imageWidth;
        }

        if (this.imageTop > this.wallHeighInt) {
          this.imageTop = this.wallHeighInt;
        }
        
      },

      ImageOrder: async function (action) {
        $('.ug_ideal-preloader-wrapper').css({'display': 'flex'});
        var orderData = new URLSearchParams();
        orderData.set('wallpaper_order_image', this.imageJson);
        orderData.set('image_src', '<?php echo $photo_galery_url.$wallpaper_detail->image->image_url; ?>');
        orderData.set('imageName', '<?php echo $wallpaper_detail->image->slug; ?>');
        orderData.set('width', this.imageWidth);
        orderData.set('top', this.imageTop);
        orderData.set('left', this.imageLeft);
        orderData.set('rotation', this.imageRotate);
        orderData.set('reflection', this.imageReflection);
        orderData.set('wall_height', this.wallHeighInt);
        orderData.set('wall_width', this.wallWidthInt);
        orderData.set('customer_mail', this.customer_mail);
        orderData.set('customer_fio', this.customer_fio);
        orderData.set('customer_phone', this.customer_phone);
        orderData.set('subject', 'Эскиз фотообоев');
        orderData.set('body', 'Юг-идеал. Эскиз фотообоев');
        orderData.set('file_path', '<?php echo get_stylesheet_directory();?>/ug_ideal-libs/dompdf/wallpaper_order.pdf');
        orderData.set('amount', this.priceTotal);
        orderData.set('discount', '');
        orderData.set('total', this.priceTotal);

        orderData.set('texture', this.texturesArr[this.currentTexture].slug);
        orderData.set('wallX', this.wallWidth);
        orderData.set('wallY', this.wallHeigh);
        orderData.set('roll', this.sizeArr[this.currentSize].post_name);

        var img = await $.get(this.theme_url +
          '/ug_ideal-core/ajax.php?' +
          orderData.toString());
        var pdf = await $.get(
          this.theme_url +
          '/ug_ideal-libs/dompdf/wallpaper_order.php?' +
          orderData.toString()
          );

        if (action == 'download') {
          window.open(this.theme_url + '/ug_ideal-libs/dompdf/wallpaper_order.pdf?v='+Math.random(), '_blank');
        }
        if (action == 'email') {
          var order = await $.get(this.theme_url + '/ug_ideal-libs/PHPMailer?' + orderData.toString());
          this.PopupHide('mailPopup');
          this.alert_text = 'Эскиз отправлен на указанную почту.';
          this.PopupShow('alertPopup');
        }
        if (action == 'order') {
          orderData.set('subject', 'Заказ фотообоев');
          orderData.set('body', 'Юг-идеал. Заказ фотообоев');
          orderData.set('order_mail', 'Y');
          var order = await $.get(this.theme_url + '/ug_ideal-libs/PHPMailer?' + orderData.toString());
          this.PopupHide('orderPopup');
          this.alert_text = 'Заказ направлен менеджеру. Мы свяжемся с вами. Подробности заказа высланы на указанную почту.';
          this.PopupShow('alertPopup');
        }
        $('.ug_ideal-preloader-wrapper').css({'display': 'none'});
      },

      fileUploadTrigger: function () {
        $('#customer_image').trigger('click');
      },

      customerImageFormSubmit: function () {
        $('#customer_image_form').trigger('submit');
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

      PopupShow: function (popup) {
        $('#'+popup).css({'height':'100vh'});
      },

      PopupHide: function (popup) {
        $('#'+popup).css({'height':'0vh'});
      },

      SetCurrentTexture: function (texture) {
        this.currentTexture = texture;
        this.PopupHide('texturesPopUp');
      },
    },

    computed: {

      priceTotal: function () {
        for (var i = 0; i < this.priceArr.length; i++) {
          if (this.priceArr[i].post_name == this.texturesArr[this.currentTexture].id) {
            var price = this.priceArr[i].post_content;
          }
        }
        var total = (this.wallHeigh  / 100 * this.wallWidth / 100) * price;
        return Math.round(total);

      },

      priceArr: function () {
        return JSON.parse(this.priceArrJson);
      },

      texturesArr: function () {
        return JSON.parse(this.texturesArrJson);
      },

      rollWidthStyle: function () {
        var axixX = this.wallpaperAxixX.split('%')[0];
        axixX = Number(axixX.split('width:')[1]);
        var part = this.sizeArr[this.currentSize].post_title / this.wallWidth;
        var roll ={
          'width': (part * 10) + '%',
        }; 
        return roll;
      },

      sizeArr: function () {
        return JSON.parse(this.sizeArrJson);
      },

      imageStyle: function () {
        return {
          'width': this.imageWidth + '%',
          'top': this.imageTop + '%',
          'left': this.imageLeft + '%',
          'transform': 'rotate('+this.imageRotate+'deg) ' + this.imageReflection,
        };
      },

      currentKoff: function () {
        var koff = this.wallHeigh / this.wallWidth;
        return koff;
      },

      wallHeighInt: function () {
        var height;
        if (this.koff > this.currentKoff) {
          height = (300 - this.wallHeigh) / 300 * 100 - (500 - this.wallWidth) / 500 * 100;
        } else {
          height = 0;
        }
        return height/2;
      },

      wallHeightStyle: function () {
        return 'height:' + this.wallHeighInt + '%'; 
      },

      wallWidthInt: function () {
        var width;
        if (this.koff < this.currentKoff) {
          width = (500 - this.wallWidth) / 500 * 100 - (300 - this.wallHeigh) / 300 * 100 * 0.6;
        } else {
          width = 0;
        }
        return width/2;
      },

      wallWidthStyle: function () {
        return {'width': this.wallWidthInt + '%',};
      },

      wallpaperAxixY: function () {
        var height =  100-this.wallHeighInt * 2;
        var bottom = this.wallHeighInt;
        // var bottom = 0;
        return 'height:' + height + '%; bottom:' + bottom + '%';
      },

      wallpaperAxixX: function () {
        var width =  100-this.wallWidthInt * 2;
        var left = this.wallWidthInt;
        return 'width:' + width + '%; left:' + left + '%';
      }

    },

  });


$('#texturesPopUp_slider').slick();
$('#interiorsPopUp_slider').slick();

</script>

<?php 

/**
 * 
 */
class Wallpaper_detail_view {
	
	function __construct($image_id) {
		global $wpdb;
    global $photo_galery_url;

    $this->rotation_arr = [
      '0/360' => 0,
      '90' => 90,
      '180' => 180,
      '270' => 270,
    ];

    $this->reflection_arr = [
      ['scale(1, 1)', 'Нет'],
      ['scale(-1, 1)', 'По горизонтали'],
      ['scale(1, -1)', 'По вертикали'],
    ];

    $this->image_id = $image_id;

    $this->image = $wpdb->get_results(
     'SELECT * FROM `wp_bwg_image`	WHERE `id`=' . $this->image_id
   )[0];

    if (isset($_FILES['customer_image'])) {
      $customer_image_ext = pathinfo($_FILES['customer_image']['name'])['extension'];
      $customer_image_url = '/customer_image.'.$customer_image_ext;
      move_uploaded_file(
        $_FILES['customer_image']['tmp_name'],
        $_SERVER['DOCUMENT_ROOT'].$photo_galery_url.$customer_image_url
      );
      echo $photo_galery_url.$customer_image_url;
      $this->image->id = 'customer_image';
      $this->image->slug = 'customer_image';
      $this->image->filename = 'customer_image';
      $this->image->image_url = $customer_image_url;
      $this->image->thumb_url = $customer_image_url;
      $this->image->filetype = $customer_image_ext;
      $this->image->alt = 'customer_image';
    }

    $this->image_json = json_encode([
      'id' => $this->image->id,
      'slug' => $this->image->slug,
      'filename' => $this->image->filename,
      'image_url' => $this->image->image_url,
      'thumb_url' => $this->image->thumb_url,
      'filetype' => $this->image->filetype,
      'alt' => $this->image->alt,
    ]);

    $this->size_arr = get_posts([
      'category_name' => 'wallpaper_roll_width',
      'orderby' => 'title',
      'order' => 'ASC',
      'numberposts' => 0,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $this->size_json = json_encode($this->size_arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $this->textures_arr = $wpdb->get_results(
      'SELECT 
      `wp_bwg_image`.`id`,
      `wp_bwg_image`.`slug`,
      `wp_bwg_image`.`image_url`,
      `wp_bwg_image`.`thumb_url`,
      `wp_bwg_image`.`alt`
      FROM `wp_bwg_gallery`
      JOIN `wp_bwg_image` ON `wp_bwg_image`.`gallery_id`=`wp_bwg_gallery`.`id`
      WHERE `wp_bwg_gallery`.`slug`="wallpaper_textures"'
    );

    $this->textures_json = json_encode($this->textures_arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $this->wallpaper_price_arr = get_posts([
      'numberposts' => 0,
      'category_name' => 'wallpaper_texture_price',
      'orderby' => 'title',
      'order' => 'ASC',
    ]);

    $this->wallpaper_json = json_encode($this->wallpaper_price_arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $this->interior_arr = $wpdb->get_results(
      'SELECT * FROM `wp_bwg_gallery`
      JOIN `wp_bwg_image` ON `wp_bwg_image`.`gallery_id`=`wp_bwg_gallery`.`id`
      WHERE `wp_bwg_gallery`.`slug`="interiors"'
    );

    $this->interior_json = json_encode($this->interior_arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  }
}

?>