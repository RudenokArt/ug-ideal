<?php 

/**
 * 
 */
class Blog_articles {
	
	function __construct($galery, $numberposts, $tape=false, $current_page=1) {

		if ($tape) {

			$this->articles_tape = new WP_Query([
				'post_type' => 'post',
				'category_name' => $galery,
				'numberposts' => $numberposts,
				'post_status' => 'publish',
				'paged' => $current_page,
				'posts_per_page' => $numberposts,
			]);
			$this->articles_list = $this->articles_tape->posts;
		} else {
			$this->articles_list = get_posts([
				'post_type' => 'post',
				'category_name' => $galery,
				'post_status' => 'publish',
				'numberposts' => $numberposts,
				'post__not_in' => [$_GET['article'], ],
			]);
		}
		

		if (isset($_GET['article'])) {
			$this->article = get_post($_GET['article']);
			$this->article->img = get_the_post_thumbnail_url($this->article->ID);
		}

		$this->getArticleImages();

	}

	function getArticleImages () {
		foreach ($this->articles_list as $key => $value) {
			$this->articles_list[$key]->img = get_the_post_thumbnail_url($value->ID);
			$excerpt = str_replace(["\r","\n"],"", $value->post_content);
			$this->articles_list[$key]->excerpt = mb_substr(trim(strip_tags($excerpt)), 0, 200);
		}
	}

}


?>