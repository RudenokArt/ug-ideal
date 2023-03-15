  <?php 
  $current_page = $wpdb->get_results(
  'SELECT `ID`, `post_name`, `post_title`
  FROM `wp_posts`
  WHERE `post_name`="'.explode('/', $_SERVER['REQUEST_URI'])[1].'"'
)[0];

  ?>

  <div class="row pt-3">
    <div class="col-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item h6">
            <a href="/<?php echo $current_page->post_name; ?>" class="smart_link">
              <?php echo $current_page->post_title ?>
            </a>
          </li>
          <?php if (isset($_GET['category']) and !empty($_GET['category'])): ?>
          <li class="breadcrumb-item h6">
            <a href="?category=<?php echo $_GET['category'];?>; ?>" class="smart_link">
              <?php echo $current_category->name; ?>
            </a>
          </li>
        <?php endif ?>           
      </ol>
    </nav>
  </div>
</div>