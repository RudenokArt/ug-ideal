<?php 

$wallpaper_order_image = new WallpaperOrderImage();

/**
 * 
 */
class WallpaperOrderImage {
	
	function __construct() {	
		$this->image = json_decode(stripslashes($_GET['wallpaper_order_image']));
		$this->top = $_GET['top'];
		$this->left = $_GET['left'];
		$this->width = $_GET['width'];
		$this->rotation = $_GET['rotation'];
		$this->reflection = $_GET['reflection'];
		$this->src_image = $_SERVER['DOCUMENT_ROOT'].$_GET['image_src'];
		$this->src_image_size = getImageSize($this->src_image);	
		$this->imageDraw();
	}

	function imageDraw () {
		$size = 500;
		$layout = imagecreatetruecolor($size, $size/5*3);
		// $white = imagecolorallocate($layout, 250, 250, 250);
    $white = imagecolorallocate($layout, 0, 0, 0);
   imagefill($layout, 0, 0, $white);

   if ($this->image->filetype == 'jpg') {
     $src_image = imageCreateFromJpeg($this->src_image);
   }
   if ($this->image->filetype == 'png') {
     $src_image = imageCreateFromPng($this->src_image);
   }
   if ($this->image->filetype == 'webp') {
     $src_image = imageCreateFromWebp($this->src_image);
   }

   $width = $size * $this->width / 100;
   $height = $this->src_image_size[1] / $this->src_image_size[0] * $size * $this->width / 100;
   $src_width = $this->src_image_size[0];
   $src_height = $this->src_image_size[1];

   $dif = 0;
   if ($this->rotation != 0) {
     $src_image = imagerotate($src_image, 360-$this->rotation, $white);
     if ($this->rotation == 90 or $this->rotation == 270) {
      $dif = ($width - $height) / 2;
      $width = $this->src_image_size[1] / $this->src_image_size[0] * $size * $this->width / 100;
      $height = $size * $this->width / 100;
      $src_width = $this->src_image_size[1];
      $src_height = $this->src_image_size[0];
    }
  }

  if ($this->reflection == 'scale(-1, 1)') {
   Imageflip($src_image, IMG_FLIP_HORIZONTAL);
 }

 if ($this->reflection == 'scale(1, -1)') {
   Imageflip($src_image, IMG_FLIP_VERTICAL);
 }

 $left = $this->left / 100 * $size + $dif;
 $top = $this->top / 100 * $size/5*3 - $dif;

 imagecopyresampled(
   $layout,
   $src_image, 
    	$left, //dst_x, 
    	$top, //dst_y, 
    	0, //src_x, 
    	0, //src_y, 
    	$width, //dst_w, 
    	$height, // dst_h, 
    	$src_width, // src_w, 
    	$src_height //src_h
    );

    if ($_GET['wall_height'] != 0) { // вертикальные шторки

      $wall_height=imagecreatetruecolor($size, $size / 5 * 3 * $_GET['wall_height'] / 100);
      $transparent=imagecolorallocatealpha($wall_height, 250, 250, 250, 25);
      imagefill($wall_height, 0, 0, $transparent);
      imagesavealpha($wall_height, true);

      imagecopyresampled(
        $layout,
        $wall_height, 
      0, //dst_x, 
      0, //dst_y, 
      0, //src_x, 
      0, //src_y, 
      $size, //dst_w, 
      $size/5*3 * $_GET['wall_height'] / 100, // dst_h, 
      $size, // src_w, 
      $size/5*3 * $_GET['wall_height'] / 100 //src_h
    );

      imagecopyresampled(
        $layout,
        $wall_height,
        0, //dst_x,
        $size / 5 * 3 - $size / 5 * 3 * $_GET['wall_height'] / 100, //dst_y,
        0, //src_x,
        0, //src_y,
        $size, //dst_w,
        $size/5*3 * $_GET['wall_height'] / 100, // dst_h,
        $size, // src_w,
        $size/5*3 * $_GET['wall_height'] / 100 //src_h
      );

    } elseif ($_GET['wall_width'] != 0) { // горизонтальные шторки

      $wall_rigth=imagecreatetruecolor($size * $_GET['wall_width'] / 100, $size / 5 * 3);
      $transparent=imagecolorallocatealpha($wall_rigth, 250, 250, 250, 25);
      imagefill($wall_rigth, 0, 0, $transparent);
      imagesavealpha($wall_rigth, true);

      imagecopyresampled(
        $layout,
        $wall_rigth,
        $size - $size * $_GET['wall_width'] / 100, //dst_x,
        0, //dst_y,
        0, //src_x,
        0, //src_y,
        $size * $_GET['wall_width'] / 100, //dst_w,
        $size/5*3, // dst_h,
        $size * $_GET['wall_width'] / 100, // src_w,
        $size/5*3 //src_h
      );

      imagecopyresampled(
        $layout,
        $wall_rigth,
        0, //dst_x,
        0, //dst_y,
        0, //src_x,
        0, //src_y,
        $size * $_GET['wall_width'] / 100, //dst_w,
        $size/5*3, // dst_h,
        $size * $_GET['wall_width'] / 100, // src_w,
        $size/5*3 //src_h
      );
    }




    imageJPEG($layout, 'order_image.jpg', 100);
  }

}

?>