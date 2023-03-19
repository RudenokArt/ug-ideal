<?php $_SESSION['back_page_url'] = $_SERVER['REQUEST_URI']; ?>

<div class="row" id="imagesView">
	<?php foreach ($images_list as $key => $value): ?>
		<div class="col-lg-4 col-md-6 col-sm-12 ug_ideal-galery-image-wrapper">
			<div v-on:click="popUpShow('<?php echo $photo_galery_url.$value->image_url;?>', '<?php echo $value->id;?>')"
				style="background-image: url(<?php echo $photo_galery_url.$value->thumb_url;?>);"
				class="ug_ideal-galery-image">
				<div class="h5 text-center text-light p-2">
					<?php echo $value->alt; ?>
				</div>
			</div>
		</div>
	<?php endforeach ?>

	<?php include_once 'catalog-images-popup.php' ?>

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