<?php 

$modular_gallery_view = new Modular_gallery_view();
$_SESSION['back_page_url'] = $_SERVER['REQUEST_URI'];

?>


<link rel="stylesheet" href="<?php echo $theme_url;?>/ug_ideal-assets/css/modular-gallery.css">

<div class="container pt-5 pb-5">
  <div class="row pt-5 pb-5">
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?php echo $modular_gallery_view->gallery_url;?>" class="content_color text_hover_color">
              <?php echo $modular_gallery_view->gallery_name; ?>
            </a>
          </li>
          <?php if ($modular_gallery_view->current_category): ?>            
            <li class="breadcrumb-item">
              <a href="?category=<?php echo $modular_gallery_view->current_category['id'];?>" class="content_color text_hover_color">
                <?php echo $modular_gallery_view->current_category['name']; ?>
              </a>
            </li>
          <?php endif ?>
          <?php if ($modular_gallery_view->current_subcategory): ?>
            <li class="breadcrumb-item active content_color text_hover_color" aria-current="page" >
              <?php echo $modular_gallery_view->current_subcategory['name']; ?>
            </li>
          <?php endif ?>
        </ol>
      </nav>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <?php include_once 'search-form.php'; ?>
    </div>
  </div>

  <div class="row">

    <div class="col-lg-3 col-md-4 col-sm-6 col-12 pb-5">
      <div id="gallery-sidebar_toggle">
        <button class="btn btn-outline-info w-100">
          <i class="fa fa-bars" aria-hidden="true"></i>
          <i class="fa fa-chevron-down" aria-hidden="true"></i>
        </button>
      </div>
      <div id="gallery-sidebar">
        <?php foreach ($modular_gallery_view->subcategories_list as $key => $value): ?>
          <div class="row pt-1">
            <?php if (sizeof($value['subcategories']) > 0): ?>
              <a href="#" data-category="<?php echo $value['id'];?>" class="col-1 smart_link text-secondary pt-1">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
                <i class="fa fa-chevron-down" aria-hidden="true" style="display:none"></i>
              </a>
            <?php endif ?>
            <a href="?category=<?php echo $value['id'] ?>" 
              class="text-secondary <?php if (isset($_GET['category']) and $_GET['category'] == $value['id']): ?>
              text-body
              <?php endif ?> col-10 smart_link h5">
              <?php echo $value['name']; ?>
            </a>
          </div>
          <?php if (sizeof($value['subcategories']) > 0): ?>
            <div data-subcategories_list="<?php echo $value['id']; ?>" class="sidebar-subcategories_list">
              <?php foreach ($value['subcategories'] as $key1 => $value1): ?>
                <div class="row pt-1 justify-content-end">
                  <a href="?category=<?php echo $value['id'];?>&subcategory=<?php echo $value1['id'];?>"
                    class="text-secondary <?php if (isset($_GET['subcategory']) and $_GET['subcategory'] == $value1['id']): ?>
                    text-body
                    <?php endif ?> col-11 smart_link">
                    <?php echo $value1['name']; ?>
                  </a>
                </div>
              <?php endforeach ?>
            </div>
          <?php endif ?>
        <?php endforeach ?>
      </div>

      <?php include_once 'sidebar-blog-articles.php'; ?>
      
    </div>

    <div class="col-lg-9 col-md-8 col-sm-6 col-12">
      <div class="row">
        <?php foreach ($modular_gallery_view->images_arr as $key => $value): ?>
          <?php $gallery_item_style = $modular_gallery_view->itemStyle($value['post_content']); ?>
          <div class="col-lg-6 col-md-12 col-sm-12 col-12 gallery-item text-start">

            <?php if (
              isset($GLOBALS['admin_current_gallery'])
              and $GLOBALS['admin_current_gallery'] == 'wallpaper'
            ): ?>
            <a href="?id=<?php echo $value['fav_link'];?>"
              style="background-image: url(<?php echo $photo_galery_url.$value['catalog_image_url'];?>);"
              class="gallery-item-image_wrapper pt-5">

              <img src="<?php echo $photo_galery_url.$value['interior']['image_url'];?>"
              alt="<?php echo $value['post_title'] ?>" class="w-100">

            </a>
          <?php else: ?>
            <?php $image_expand = $modular_gallery_view->imageExpand($value['post_content']); ?>
            <a href="?id=<?php echo $value['post_name'];?>" class="gallery-item-image_wrapper pt-5">
             <div <?php if ($image_expand): ?>
               style="width:80%; left:10%; top: -5%"
             <?php endif ?> class="gallery-item-image_inner"> 
              <img src="<?php echo $photo_galery_url.$value['catalog_image_url'];?>"
              style="<?php echo $gallery_item_style;?>"
              class="gallery-item-image" alt="">
              <?php if (isset($value['template']['image_url']) and !empty($value['template']['image_url'])): ?>
              <img src="<?php echo $photo_galery_url.$value['template']['image_url'];?>"
              alt="<?php echo $value['post_title'] ?>" class="w-100">
            <?php endif ?>              
          </div>
          <?php if (isset($value['interior']['image_url']) and !empty($value['interior']['image_url'])): ?>
          <img src="<?php echo $photo_galery_url.$value['interior']['image_url'];?>"
          alt="<?php echo $value['post_title'] ?>" class="w-100">
        <?php else: ?>
          <img src="<?php echo $theme_url;?>/ug_ideal-assets/img/default_interior.png" alt="">
        <?php endif ?>
      </a>
    <?php endif ?>



    <div class="row pt-3">
      <a href="?id=<?php echo $value['post_name'];?>" 
        class="col-4 smart_link content_color text_hover_color" title="Редактировать в конструкторе">
        <?php echo $value['post_title'];?>
      </a> 
      <div class="col-4">
        <?php if (isset($value['post_category']['parent_id']) and !empty($value['post_category']['parent_id'])): ?>
        <a href="?category=<?php echo $value['post_category']['parent_id'];?>" class="col smart_link content_color text_hover_color">
          <?php echo $value['post_category']['parent'];?>
        </a>
        /
        <a href="?category=<?php echo $value['post_category']['parent_id'];?>&subcategory=<?php echo $value['post_category']['id'];?>" class="smart_link content_color text_hover_color">
          <?php echo $value['post_category']['name'];?>
        </a>
      <?php else: ?>
        <a href="?category=<?php echo $value['post_category']['id'];?>" class="smart_link content_color text_hover_color">
          <?php echo $value['post_category']['name'];?>
        </a>
      <?php endif ?>
    </div>  
    <div class="col-4 h6 text-info">
      <?php if (!(isset($GLOBALS['admin_current_gallery']) and $GLOBALS['admin_current_gallery'] == 'wallpaper')): ?>
       <a href="?id=<?php echo $value['post_name'];?>" class="col-4 smart_link content_color text_hover_color" title="подробнее">
        <?php print_r(Modular_gallery_view::getTemplatePrice($value['template']['id'])); ?>
      </a> 
    <?php endif; ?>
  </div> 
</div>
<div class="favorite-item-icon" id="<?php echo $value['fav_link'];?>">
  <i class="fa fa-star" aria-hidden="true"></i>
  <i class="fa fa-star-o" aria-hidden="true"></i>
</div>
<?php if (!isset($GLOBALS['admin_current_gallery'])): ?>
  <?php if (current_user_can('manage_options')): ?>
    <a href="?edit=<?php echo $value['post_id'];?>">
      <i class="fa fa-wrench" aria-hidden="true"></i>
    </a>
  <?php endif ?>
<?php endif ?>    
<hr>
</div>
<?php endforeach ?>

</div>
</div>

</div>

<div class="row pt-5 justify-content-center">
  <div class="col-lg-3 col-md-4 col-sm-6 col-12">
    <nav aria-label="Page navigation example">
      <ul class="pagination p-0 m-0">
        <?php if ($modular_gallery_view->pagination['paged'] != 1): ?>
          <li class="page-item">
            <a href="?<?php echo $_SERVER['QUERY_STRING'];?>&pageN=<?php echo ($modular_gallery_view->pagination['paged']-1);?>" class="page-link" aria-label="Previous">
              <span aria-hidden="true">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
              </span>
            </a>
          </li>
        <?php endif ?>
        <?php for ($i=1; $i <= $modular_gallery_view->pagination['max_num_pages']; $i++): ?>
          <?php if (
            ($i > $modular_gallery_view->pagination['paged']-3 and $i < $modular_gallery_view->pagination['paged']+3)
            or
            $i == 1
            or
            $i == $modular_gallery_view->pagination['max_num_pages']
          ): ?>
          <li class="page-item <?php if ($modular_gallery_view->pagination['paged'] == $i): ?>
          active
          <?php endif ?>">
          <a href="?<?php echo $_SERVER['QUERY_STRING'];?>&pageN=<?php echo $i;?>" class="page-link">
            <?php echo $i; ?>
          </a>
        </li>
      <?php endif ?>
    <?php endfor ?>
    <?php if ($modular_gallery_view->pagination['paged'] != $modular_gallery_view->pagination['max_num_pages']): ?>
      <li class="page-item">
        <a
        href="?<?php echo $_SERVER['QUERY_STRING'];?>&pageN=<?php echo ($modular_gallery_view->pagination['paged']+1);?>" aria-label="Next" class="page-link" >
        <span aria-hidden="true">
          <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </span>
      </a>
    </li>
  <?php endif ?>
</ul>
</nav>
</div>
</div>


<div class="add_to_favorite" id="add_to_favorite_image">
  <img class="add_to_favorite_image" src="<?php echo get_stylesheet_directory_uri();?>/ug_ideal-assets/img/add_to_favorite.png" alt="">
</div>
<a href="/favorite/" class="ug_ideal-favorite_counter">
  <i class="fa fa-star" aria-hidden="true"></i>
  <hr>
  <span id="favoriteCounter"></span>
</a>

</div>




<script>


  $(function () {

    $('#gallery-sidebar_toggle').click(function () {
      $('#gallery-sidebar').slideToggle();
    });


    favoriteItemsCheck();
    $('.favorite-item-icon').click(function () {
      var arr = JSON.parse(localStorage.getItem('ug_ideal_favorite'));
      if (!arr) {
        arr = [];
      }
      if (!arr.includes(this.id)) {
        arr.push(this.id);
        $('#add_to_favorite_image').prop('className', 'add_to_favorite-active');
        setTimeout(function () {
          $('#add_to_favorite_image').prop('className', 'add_to_favorite');
        }, 100);
      } else {
        newArray = [];
        for (var i = 0; i < arr.length; i++) {
          if (arr[i] != this.id) {
            newArray.push(arr[i]);
          }
        }
        arr = newArray;
      }
      localStorage.setItem('ug_ideal_favorite', JSON.stringify(arr));
      favoriteItemsCheck();
    });

  });

  function favoriteItemsCheck () {
    var favoriteArr = JSON.parse(localStorage.getItem('ug_ideal_favorite'));
    if (favoriteArr && favoriteArr.length > 0) {
      $('#favoriteCounter').html(favoriteArr.length);
    } else {
      $('#favoriteCounter').html(0);
      favoriteArr = [];
    }
    var starsArr = $('.favorite-item-icon');
    for (var i = 0; i < starsArr.length; i++) {
      var icons = $(starsArr[i]).find('i');
      $(icons).hide();
      if (favoriteArr.includes(starsArr[i].id)) {
        $(icons[0]).show();
      } else {
        $(icons[1]).show();
      }
    }
  }

  $(function () {
    $('a[data-category]').click(function (e) {
      e.preventDefault();
      $('div[data-subcategories_list=' + $(this).attr('data-category') + ']').slideToggle();
      $(this).children('i').toggle();
    });
  });
</script>

<?php if (isset($_GET['category'])): ?>
  <script>
    $(function () {
      data_category = "<?php echo $_GET['category'];?>";
      $('a[data-category="' + data_category + '"]')[0].click();
    });
  </script>  
<?php endif ?>

<?php 

/**
 * 
 */
class Modular_gallery_view {

  public static $template_size_arr;
  function __construct() {
    $this->pagination = ['paged' => 1];
    if (isset($_GET['pageN'])) {
      $this->pagination['paged'] = $_GET['pageN'];
    }

    if (isset($GLOBALS['admin_current_gallery']) and $GLOBALS['admin_current_gallery'] == 'wallpaper') {
      $this->modular_category = get_category_by_slug('wallpaper');
      $this->prefix = 'wallpaper_';
      $this->gallery_name = 'Фотообои';
      $this->gallery_url = '/wallpaper/';
    } else {
      $this->modular_category = get_category_by_slug('modular_pictures');
      $this->prefix = '';
      $this->gallery_name = 'Модульные картины';
      $this->gallery_url = '/modular/';
      self::$template_size_arr = get_posts([
        'numberposts' => 0,
        'category_name' => 'modular_template_size',
      ]);
    }

    $this->categories_list = get_categories([
      'taxonomy' => 'category',
      'type' => 'post',
      'parent' => $this->modular_category->cat_ID,
    ]);

    $this->subcategories_list = $this->getSubcategoriesList();
    $this->current_category = $this->getCurrentCategory();
    $this->current_subcategory = $this->getCurrentSubcategory();
    $this->posts_arr = $this->getPostsArr();
    $this->images_arr = $this->getImagesArr();
    $this->pagination['max_num_pages'] = $this->post_src->max_num_pages;
  }

  public static function getTemplatePrice ($template_img) {

    $template_post = get_posts([
      'name' => $template_img,
      'category_name' => 'modular_template_price',
      'numberposts' => 0,
    ]);
    $post_content = json_decode($template_post[0]->post_content, true);
    foreach (self::$template_size_arr as $key => $value) {
      $arr[] = $post_content[$value->ID];
    }
    if (min($arr) > 0) {
      return 'от ' . min($arr) . ' руб.';
    } else {
      return false;
    }
  }

  function imageExpand ($json) {
    $arr = json_decode($json, true);
    if ($arr['image_expand']) {
      return true;
    }
  }

  function itemStyle ($json) {
    $style = '';
    if ($json) {
      $arr = json_decode($json, true);
      if (isset($arr['top'])) {
        $style = $style . 'top: '.$arr['top'].'%; ';
      }
      if (isset($arr['left'])) {
        $style = $style . 'left: '.$arr['left'].'%; ';
      }
      if (isset($arr['width'])) {
        $style = $style . 'width: '.$arr['width'].'%; ';
      }
    }
    return $style;
  }

  function getImagesArr () {
    $arr = [];
    foreach ($this->posts_arr as $key => $value) {
      if ($this->prefix != '') {
        $img_id = explode($this->prefix, $value->post_name)[1];
      } else {
        $img_id = $value->post_name;
      }
      $post_category = $this->getPostCategory($value->ID, $value->post_content);
      $arr[$key] = [
        'post_id' => $value->ID,
        'post_name' => $value->post_name,
        'post_title' => $value->post_title,
        'post_content' => $value->post_content,
        'catalog_image_url' => $this->getCatlogImage($img_id),
        'fav_link' => $img_id,
        'post_category' => [
          'id' => $post_category['id'],
          'name' => $post_category['name'],
        ],
      ];
      if (isset($post_category['cat_img']['template']) and !empty($post_category['cat_img']['template'])) {
        $arr[$key]['template'] = $post_category['cat_img']['template'];
      }
      if (isset($post_category['cat_img']['interior']) and !empty($post_category['cat_img']['interior'])) {
        $arr[$key]['interior'] = $post_category['cat_img']['interior'];
      }
      if (isset($post_category['parent_id']) and !empty($post_category['parent_id'])) {
        $arr[$key]['post_category']['parent_id'] = $post_category['parent_id'];
        $arr[$key]['post_category']['parent'] = $post_category['parent'];
      }
    }
    return $arr;
  }

  function getPostCategory ($post_id, $post_content) {
    $arr = get_the_category($post_id);
    $category = [
      'id' => $arr[0]->cat_ID,
      'name' => $arr[0]->name,
    ];


    if ($post_content) {
      $category['cat_img'] = $this->getPostContent($post_content);
    } else {
      $category['cat_img'] = $this->getPostCategoryMeta($arr[0]->cat_ID);
    }

    if ($arr[0]->category_parent != $this->modular_category->cat_ID) {
      $category['parent_id'] = $arr[0]->category_parent;
      $category['parent'] = get_cat_name($arr[0]->category_parent);
    }
    return $category;
  }

  function getPostContent ($post_content) {
    $content = json_decode($post_content, true);
    if (isset($content['template_id'])) {
      $arr['template']['id'] = $content['template_id'];
      $arr['template']['image_url'] = $this->getCatlogImage($content['template_id']);
    }
    if (isset($content['interior_id'])) {
      $arr['interior']['image_url'] = $this->getCatlogImage($content['interior_id']);
    }
    return $arr;
  }

  function getPostCategoryMeta ($cat_ID) {
    $meta = get_term_meta($cat_ID);
    $arr = [];
    if ($meta) {
      if (isset($meta['template']) and !empty($meta['template'])) {
        $arr['template']['id'] = $meta['template'][0];
        $arr['template']['image_url'] = $this->getCatlogImage($meta['template'][0]);
      }
      if (isset($meta['interior']) and !empty($meta['interior'])) {
        $arr['interior']['id'] = $meta['interior'][0];
        $arr['interior']['image_url'] = $this->getCatlogImage($meta['interior'][0]);
      }
    }
    return $arr;
  }

  function getCatlogImage ($image_id) {
    global $wpdb;
    $img = $wpdb->get_results(
      'SELECT `image_url` FROM `wp_bwg_image`
      WHERE `id`=' . $image_id
    );
    if ($img) {
      return $img[0]->image_url;
    }
    return false;
  }

  function getPostsArr () {
    $arr = [
     'paged' => $this->pagination['paged'],
     'post_type' => 'post',
     'cat' => $this->modular_category->cat_ID,
     'post_status' => 'publish',
     'posts_per_page' => 10,
   // 'order' => 'DESC',
     'orderby' => 'meta_value_num',
     'meta_query' => array(
      'relation' => 'OR',
      array(
        'key' => 'sorting',
        'compare' => 'EXISTS'
      ),
      array(
        'key' => 'sorting',
        'compare' => 'NOT EXISTS'
      ),
    )

   ];
   if (isset($_GET['category']) and isset($_GET['subcategory'])) {
     $arr['cat'] = $_GET['subcategory'];
   } elseif (isset($_GET['category'])) {
     $arr['cat'] = $_GET['category'];
   }
   if (isset($_GET['search'])) {
     $arr['s'] = $_GET['search'];
   }
   $this->post_src = new WP_Query($arr);
   // return get_posts($arr);
   return $this->post_src->posts;
 }

 function getCurrentSubcategory () {
  if (isset($_GET['subcategory'])) {
    foreach ($this->current_category['subcategories'] as $key => $value) {
      if ($value['id'] == $_GET['subcategory']) {
        return $value;
      }
    }
  }
  return false;
}

function getCurrentCategory () {
  if (isset($_GET['category'])) {
    foreach ($this->subcategories_list as $key => $value) {
      if ($value['id'] == $_GET['category']) {
        return $value;
      }
    }
  }
  return false;
}

function getSubcategoriesList () {
  $list = [];
  foreach ($this->categories_list as $key => $value) {
    $subcategories = get_categories([
      'taxonomy' => 'category',
      'type' => 'post',
      'parent' =>$value->cat_ID,
    ]);
    $sub_list = [];
    foreach ($subcategories as $key1 => $value1) {
      array_push($sub_list, [
        'id' => $value1->cat_ID,
        'name' => $value1->name,
      ]);
    }
    array_push($list, [
      'id' => $value->cat_ID,
      'name' => $value->name,
      'subcategories' => $sub_list,
    ]);
  }
  return $list;
}

}

?>