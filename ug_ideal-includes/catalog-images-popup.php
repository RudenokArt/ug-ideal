<div v-if="popUpVisible" class="ug_ideal-galery-image-popup-wrapper">
		<div class="ug_ideal-galery-image-popup">
			<div class="text-end">
				<span v-on:click="popUpVisible=false" class="text-danger h3">
					<i class="fa fa-times" aria-hidden="true"></i>
				</span>
			</div>
			<div class="ug_ideal-galery-image-popup-links h5">
				<a href="#" v-on:click.prevent="popUpExpand=true" title="На весь экран" class="ug_ideal-galery-image-expand">
					<i class="fa fa-arrows-alt" aria-hidden="true"></i>
				</a>
				<a href="#" v-if="!favoriteAddStarIcon" v-on:click.prevent="addToFavorite" title="Добавить в избранное">
					<i class="fa fa-star-o" aria-hidden="true"></i>
				</a>
				<a href="#" v-if="favoriteAddStarIcon" v-on:click.prevent="removeFromFavorite" title="Удалить из избранного">
					<i class="fa fa-star" aria-hidden="true"></i>
				</a>
				<a v-bind:href="`/modular/?id=${popUpImageId}`" title="Просмотреть изображение в конструкторе модульных картин">
					<i class="fa fa-chevron-right" aria-hidden="true"></i>
					В модульные картины
				</a>
				<a v-bind:href="`/wallpaper/?id=${popUpImageId}`" title="Просмотреть изображение в конструкторе фотообоев">
					<i class="fa fa-chevron-right" aria-hidden="true"></i>
					В фотообои
				</a>
			</div>		
			<div>
				<img v-bind:src="popUpImageUrl" alt="">
			</div>
		</div>
	</div>

	<div v-bind:style="popUpImageBackground" v-if="popUpExpand" class="ug_ideal-galery-image-popup-expand">
		<div class="ug_ideal-galery-image-popup-expand-false text-danger h3" title="Свернуть" v-on:click="popUpExpand=false">
			<i class="fa fa-times" aria-hidden="true"></i>
		</div>
	</div>

	<div v-bind:class="favoriteAddImage">
		<img class="add_to_favorite_image" src="<?php echo get_stylesheet_directory_uri();?>/ug_ideal-assets/img/add_to_favorite.png" alt="">
	</div>