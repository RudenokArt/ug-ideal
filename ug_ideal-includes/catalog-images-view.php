<?php $_SESSION['back_page_url'] = $_SERVER['REQUEST_URI']; ?>

<div class="row">
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

</div>




