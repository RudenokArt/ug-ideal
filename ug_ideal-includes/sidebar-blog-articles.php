<?php 
include_once $theme_path.'/ug_ideal-core/Blog_articles.php';
if (isset($GLOBALS['admin_current_gallery']) and $GLOBALS['admin_current_gallery'] == 'wallpaper') {
	$blog_articles = new Blog_articles('blog_articles_wallpaper', 4);
} else {
	$blog_articles = new Blog_articles('blog_articles_modular', 4);
}
?>

<div class="pt-5">
	<?php foreach ($blog_articles->articles_list as $key => $value): ?>
		<a href="/blog_articles/?article=<?php echo $value->ID;?>" class="pt-3 pb-3 d-block border-top smart_link text-body">
			<span class=""><?php echo mb_substr($value->post_date, 0, 10); ?></span>
			<div class="h6"><?php echo $value->post_title;?></div>
			<div>
				<img src="<?php echo $value->img; ?>" alt="<?php echo $value->post_title; ?>">
			</div>
			<div>
				<?php echo $value->excerpt;?>
				<i><b class="text-primary">... читать полностью</b></i>
			</div>
		</a>
	<?php endforeach ?>
	<div class="pt-3">
		<a href="/blog_articles/" class="btn btn-outline-light border w-100">
			<div class="content_color text_hover_color w-100">
				Все статьи
			</div>
		</a>
	</div>
	
</div>

