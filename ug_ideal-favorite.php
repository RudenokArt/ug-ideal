<?php 

/*
Template Name: ug_ideal-favorite
*/


?>

<?php include_once 'ug_ideal-includes/header.php'; ?>

<div class="container pt-5 pb-5 ug_ideal-galery">
  <div class="text-uppercase page_title"><?php include_once 'ug_ideal-includes/breadcrumb.php';?></div>
  <div id="ug_ideal-favorite_view">
    <div class="row pb-3 pt-3 border-bottom" v-for="(item, index) in favoriteArr">
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <img v-bind:src="`<?php echo $photo_galery_url;?>${item.image_url}`" alt="">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="h5">Артикул: {{item.filename}}</div>
        <div class="h5">Категория: {{item.name}}</div>
        <div class="pt-2">
          <a href="#" v-on:click.prevent="removeFromFavorite(item.id)" class="btn btn-outline-danger w-100">
            <i class="fa fa-trash-o" aria-hidden="true"></i>
            Удалить
          </a>
        </div>
        <div class="pt-2">
          <a v-bind:href="`/modular/?id=${item.id}`" class="btn btn-outline-success w-100">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
            Просмотреть в конструкторе модульных картин
          </a>
        </div>
        <div class="pt-2">
          <a v-bind:href="`/wallpaper/?id=${item.id}`" class="btn btn-outline-success w-100">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
            Просмотреть в конструкторе фотообоев
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once 'ug_ideal-includes/preloader.php' ?>


<script>

 new Vue ({
  el: '#ug_ideal-favorite_view',
  data: {
    photoGaleryUrl:'<?php echo $photo_galery_url;?>',
    favoriteStr: '',
    favoriteArr: [],
  },

  methods:{
    getItemsList: async function () {
      this.favoriteStr = localStorage.getItem('ug_ideal_favorite');
      if (this.favoriteStr) {
       var url = '<?php echo get_stylesheet_directory_uri();?>/ug_ideal-core/ajax.php?';
       var queryString = 'get_favorite_list='+this.favoriteStr;
       var list = await $.get(url+queryString, function (data) {return data;});
       this.favoriteArr = JSON.parse(list);
     }
     $('.ug_ideal-preloader-wrapper').css({'display': 'none'});
   },

   removeFromFavorite: function (id) {
    $('.ug_ideal-preloader-wrapper').css({'display': 'flex'});
    var arr = JSON.parse(localStorage.getItem('ug_ideal_favorite'));
    newArray = [];
    for (var i = 0; i < arr.length; i++) {
      if (arr[i] != id) {
        newArray.push(arr[i]);
      }
    }
    this.favoriteAddStarIcon = false;
    this.favoriteCounter = newArray.length;
    localStorage.setItem('ug_ideal_favorite', JSON.stringify(newArray));
    this.getItemsList();
  },

},


mounted: function () {
  this.getItemsList();
},

});

</script>

<?php get_footer(); ?>