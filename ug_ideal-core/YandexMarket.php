<?php 
require_once ABSPATH . '/wp-admin/includes/taxonomy.php';
$yaMarket = new YandexMarket ();

/**
 * 
 */
class YandexMarket {
	
	function __construct() {

		$img_folder = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/yandex_market';

		if (!is_dir($img_folder)) {
			mkdir($img_folder);
		}

		$this->modular_category = get_category_by_slug('yandex_market_modular');
		if (!$this->modular_category) {
			$add = wp_insert_category([
				'cat_name' => 'Яндекс каталог - модульные',
				'category_description' => 'Яндекс каталог - модульные картины для выгрузки в маркет',
				'category_nicename' => 'yandex_market_modular',
			], true);
			print_r($add);
			$this->modular_category = get_category_by_slug('yandex_market_modular');
		}

		if (isset($_GET['save']) and $_GET['save'] == 'Y') {
			print_r($this->productSave());
		}

		if (isset($_REQUEST['update']) and $_REQUEST['update'] == 'Y') {
			$this->productUpdate();
		}
		
	}

	function productUpdate () {
		wp_update_post(wp_slash([
			'ID' => $_REQUEST['ID'],
			'post_content' => $this->setProductPostContent($_REQUEST),
		]));
	}

	function getProductList () {
		$src = new WP_Query([
			'category_name' => $this->modular_category->slug,
			'order' => 'ASC',
			'orderby' => 'ID',
		]);
		return $src;
	}

	function productSave () {
		
		copy('order_image.jpg', $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/yandex_market/'.$_GET['shopSku'].'.jpg');

		$postArr = [
			'post_name' => $_GET['post_slug'],
			'post_title' => $_GET['name'],
			'post_category' => [$this->modular_category->cat_ID],
			'post_status' => 'publish',
			'post_content' => $this->setProductPostContent($_GET),
		];

		$checkPost = get_posts([
			'name' => $_GET['post_slug'],
			'post_status' => 'any',
		]);

		if ($checkPost) {
			$postArr['ID'] = $checkPost[0]->ID;
		}

		// return $checkPost;

		return wp_insert_post($postArr, true);

	}

	function setProductPostContent ($arProp) {
		$arr = [
			"offerMappings" => [
				[
					"offer" => [
						"name" => $arProp['name'], 
						"offerId" => $arProp['shopSku'], 
						"category" => "Модульные картины", 
						"vendor" => "Юг Идеал", 
						"vendorCode" => $arProp['vendorCode'],
						"description" => $arProp['description'],
						"urls" => [
							$arProp['urls'],
						], 
						"pictures" => [
							$arProp['pictures'],
						], 
						"manufacturer" => "", 
						"manufacturerCountries" => [
							"Россия" 
						], 
						"minShipment" => 0, 
						"transportUnitSize" => 1, 
						"quantumOfSupply" => 0, 
						"deliveryDurationDays" => 0, 
						"weightDimensions" => [
							"length" => (int) $arProp['length'], 
							"width" => (int) $arProp['width'], 
							"height" => (int) $arProp['height'],
							"weight" => (int) $arProp['weight'],
						], 
						"availability" => "ACTIVE", 
						"certificate" => "" 
					], 
				] 
			],
			"basicPrice" => (int) $arProp['price'],
		]; 
		return json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	}



}

?>