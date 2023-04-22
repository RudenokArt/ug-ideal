<?php 
/*
Template Name: ug_ideal-blog
*/
include_once 'ug_ideal-includes/header.php';


include_once $theme_path.'/ug_ideal-core/Blog_articles.php';
if (isset($_GET['article'])) {
	$blog_articles = new Blog_articles('blog_articles', 5);
} else {
	$current_page = 1;
	if ($_GET['page_N']) {
		$current_page = $_GET['page_N'];
	}
	$blog_articles = new Blog_articles('blog_articles', 5, true, $current_page);
	$pages_qty = ceil($blog_articles->articles_tape->found_posts / $blog_articles->articles_tape->query['numberposts']);
}
?>

<div class="container pb-5">
	<?php if (isset($_GET['article'])): ?>
		<div class="row">
			<div class="col-lg-9 col-md-8 col-sm-12 col-12">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12 col-12 h-100">
						<script>document.write('<img src="<?php echo $blog_articles->article->img; ?>" alt="">')</script>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="h1">
							<?php echo $blog_articles->article->post_title; ?>
						</div>
						<?php echo mb_substr($blog_articles->article->post_date, 0, 10); ?>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-12 pt-3">
						<?php echo $blog_articles->article->post_content; ?>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-12 col-12">
				<?php foreach ($blog_articles->articles_list as $key => $value): ?>
					<a href="/blog_articles/?article=<?php echo $value->ID;?>"
						class="pt-3 pb-3 d-block border-bottom smart_link text-body">
						<span class=""><?php echo mb_substr($value->post_date, 0, 10); ?></span>
						<div class="h6"><?php echo $value->post_title;?></div>
						<div>
							<script>document.write('<img src="<?php echo $value->img; ?>">')</script>
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
		</div>
	<?php else: ?>
		
		<?php foreach ($blog_articles->articles_list as $key => $value): ?>
			<a href="/blog_articles/?article=<?php echo $value->ID;?>" class="row pt-5 smart_link text-body">
				<div class="col-lg-4 col-md-6 col-sm-12 col-12">
					<script>document.write('<img src="<?php echo $value->img; ?>">')</script>
				</div>
				<div class="col-lg-8 col-md-6 col-sm-12 col-12">
					<span class=""><?php echo mb_substr($value->post_date, 0, 10); ?></span>
					<div class="h2"><?php echo $value->post_title;?></div>
					<?php echo $value->excerpt;?>
					<i><b class="text-primary">... читать полностью</b></i>
				</div>
			</a>
		<?php endforeach ?>

		<div class="row justify-content-center">
			<div class="col-lg-4 col-md-6 col-sm-12 col-12">
				<nav aria-label="Page navigation example">
					<ul class="pagination">
						<li class="page-item">
							<a class="page-link" href="page_N=1" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<?php for($i=1; $i <= $pages_qty ; $i++): ?>
							<?php if ($i >= $current_page-2 and $i <= $current_page+2): ?>
								<li class="page-item">
									<a class="page-link <?php if ($current_page == $i): ?>
									text-danger
									<?php endif ?>" href="?page_N=<?php echo $i;?>">
									<?php echo $i ?>
								</a>
							</li>
						<?php endif ?>

					<?php endfor; ?>
					<li class="page-item">
						<a class="page-link" href="?page_N=<?php echo $i-1;?>" aria-label="Next">
							<span aria-hidden="true">&raquo;</span>
						</a>
					</li>
				</ul>
			</nav>
		</div>
	</div>
<?php endif ?>
</div>

<?php get_footer(); ?>