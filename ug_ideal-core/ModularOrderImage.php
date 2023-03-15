<?php 
$order_image = new OrderImage();
print_r($order_image);

/**
 * 
 */
class OrderImage {
	
	function __construct() {
    $this->image = json_decode(stripslashes($_GET['image']));
    $this->template = json_decode(stripslashes($_GET['template']));
    $this->top = $_GET['top'];
    $this->left = $_GET['left'];
    $this->width = $_GET['width'];
    $this->rotation = $_GET['rotation'];
    $this->reflection = $_GET['reflection'];
    $this->src_image_path = $_SERVER['DOCUMENT_ROOT'].$_GET['folder'].$this->image->image_url;
    $this->src_image_size = getImageSize($this->src_image_path);
    $this->src_template_path = ($_SERVER['DOCUMENT_ROOT'].$_GET['folder'].$this->template->image_url);
    $this->src_template = imageCreateFromPng($this->src_template_path);
    $this->src_template_size = getImageSize($this->src_template_path);
    $this->imageDraw();
  }

  function imageDraw () {
    $size = 600;
    if ($this->image->filetype == 'jpg') {
      $src_image = imageCreateFromJpeg($this->src_image_path);
    }
    if ($this->image->filetype == 'png') {
      $src_image = imageCreateFromPng($this->src_image_path);
    }
    if ($this->image->filetype == 'webp') {
      $src_image = imageCreateFromWebp($this->src_image_path);
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
    $top = $this->top / 100 * $size - $dif;
    $layout = imagecreatetruecolor($size, $size);
    imagecopyresampled(
      $layout,
      $src_image,
      $left,
      $top,
      0,
      0,
      $width,
      $height,
      $src_width,
      $src_height
      
    );
    
    imagecopyresampled(
      $layout,
      $this->src_template,
      0,
      0,
      0,
      0,
      $size,
      $size,
      $this->src_template_size[0],
      $this->src_template_size[0]
    );
    imageJPEG($layout, 'order_image.jpg', 100);
  }
}

?>