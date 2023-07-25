<?php 
include_once __DIR__.'/admin-header.php';
include_once $theme_path.'/ug_ideal-core/YandexMarket.php';
$yaMarketApi = new YandexMarketApi();
$yandex_market_catalog_alert = ['show' => false, 'text' => '', 'color' => 'light'];
if (isset($_POST['yandex_market_catalog_update']) and $_POST['yandex_market_catalog_update'] == 'Y') {
	$yandex_market_catalog_alert = $yaMarketApi->yandexMarketCatalogUpdate($yaMarket->getProductList()->posts);
}
if (isset($_POST['delete']) and $_POST['delete'] == 'Y') {
	$yandex_market_catalog_alert = $yaMarketApi->yandexMarketCatalogDelete([
		'post_id' => $_POST['ID'],
		'shopSku' => $_POST['shopSku'],
	]);
}
?>

<div class="container pt-5">
	<div class="row justify-content-end pb-5">
		<div class="col-lg-8 col-md-6 col-sm-12">
			<?php if ($yandex_market_catalog_alert['show']): ?>
				<div class="alert alert-<?php echo $yandex_market_catalog_alert['color']?> text-center">
					<?php echo $yandex_market_catalog_alert['text']?>
				</div>
			<?php endif ?>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12">
			<form action="" method="post">
				<button class="btn btn-primary" name="yandex_market_catalog_update" value="Y">
					<i class="fa fa-cloud-upload" aria-hidden="true"></i>
					Синхронизация с маркетом
				</button>
			</form>
		</div>
	</div>
	<?php foreach ($yaMarket->getProductList()->posts as $key => $value): ?>
		<form action="" method="post" class="row border-bottom border-secondary pt-5 pb-5">
			<?php
			$value->content_arr = json_decode($value->post_content, true);
			$value->content = $value->content_arr['offerMappings'][0]['offer'];
			$value->price = $value->content_arr['basicPrice'];
			?>
			<div class="col-lg-8 col-md-6 col-sm-12">
				<div class="h6">
					<input type="text" class="form-control w-100" name="name" value="<?php echo $value->content['name']?>">
				</div>
				<div class="text-secondary">
					<b>Описание:</b>
					<textarea name="description" class="form-control"><?php echo $value->content['description']?></textarea>
					
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-12 col-sm-12 pt-1 text-end">
						Длинна в упаковке:
						<input type="number" min="0" step="1" class="w-25" name="length" value="<?php echo $value->content['weightDimensions']['length']?>">
						см.
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12 pt-1 text-end">
						Ширина в упаковке:
						<input type="number" min="0" step="1" class="w-25" name="width" value="<?php echo $value->content['weightDimensions']['width']?>">
						см.
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12 pt-1 text-end">
						Высота в упаковке:
						<input type="number" min="0" step="1" class="w-25" name="height" value="<?php echo $value->content['weightDimensions']['height']?>">
						см.
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12 pt-1 text-end">
						Вес в упаковке:
						<input type="number" min="0" step="1" class="w-25" name="weight" value="<?php echo $value->content['weightDimensions']['weight']?>">
						кг.
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12 pt-1 text-end">
						Основная цена:
						<input type="number" min="0" step="1" class="w-25" name="price" value="<?php echo $value->price;?>">
						руб.
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12 pt-1 text-end">
						<input type="hidden" name="ID" value="<?php echo $value->ID; ?>">
						<input type="hidden" name="shopSku" value="<?php echo $value->content['offerId']; ?>">
						<input type="hidden" name="vendorCode" value="<?php echo $value->content['vendorCode']; ?>">
						<input type="hidden" name="urls" value="<?php echo $value->content['urls'][0]; ?>">
						<input type="hidden" name="pictures" value="<?php echo $value->content['pictures'][0]; ?>">
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<div class="container">
					<div class="row">
						<div class="col-8">
							<img src="<?php echo $value->content['pictures'][0];?>" class="w-100 border" alt="">
						</div>
						<div class="col-4">
							<button class="btn btn-success btn-lg w-100" name="update" value="Y">
								<i class="fa fa-floppy-o" aria-hidden="true"></i>
							</button>
							<hr>
							<button class="btn btn-danger btn-lg w-100" name="delete" value="Y">
								<i class="fa fa-trash-o" aria-hidden="true"></i>
							</button>
						</div>
					</div>
				</div>				
			</div>
		</form>
	<?php endforeach ?>
</div>



<pre><?php // print_r($yaMarket->getProductList()->posts); ?></pre>
<pre><?php // print_r($yaMarketApi->getCatalogProductList()); ?></pre>

<hr>

<?php 

/**
 * 
 */
class YandexMarketApi {
	
	function __construct() {
		$this->companyId = '60165900';
		$this->cabinetId = '64760255';
		$this->token = 'y0_AgAAAABHHQGdAAna0QAAAADiYnYyH0pabVJYQMub2aCcx8Q34WY2IVk';
		$this->companyUrl = 'https://api.partner.market.yandex.ru/campaigns/';
		$this->cabinetUrl = 'https://api.partner.market.yandex.ru/businesses/';
	}

	function yandexMarketCatalogDelete ($arr) {
		unlink($_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/yandex_market/'.$arr['shopSku'].'.jpg');
		wp_delete_post($arr['post_id'], true);
		$url = $this->cabinetUrl.$this->cabinetId."/offer-mappings/delete";
		$data_json = '{
			"offerIds": [
			"'.$arr['shopSku'].'"
		]}';
		$this->restApiRequest($url, $data_json);
		return ['show' => true, 'text' => 'Запрос на удаление отправлен в маркет', 'color' => 'warning'];
	}

	function yandexMarketCatalogUpdate ($arr) {
		foreach ($arr as $key => $value) {
			$catalog = $this->updateCatalogPorduct($value->post_content);
			$price = $this->updateCatalogPorductPrice($value->post_content);
			$shop = $this->updateShopProduct($value->post_content);
		}
		return ['show' => true, 'text' => 'Данные отправлены в маркет', 'color' => 'success'];
	}



	function restApiRequest ($url, $data) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$headers = array(
			"Accept: application/json",
			"Authorization: Bearer ".$this->token,
			"Content-Type: application/json",
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$resp = curl_exec($curl);
		curl_close($curl);
		// // 4debug
		// echo '<pre>';
		// echo $url;
		// print_r(json_decode($resp, true));
		// echo '</pre>';
	}

	function updateShopProduct ($data) {
		$url = $this->companyUrl.$this->companyId."/offers/update";
		$arr = json_decode($data, true);
		$data_json = '{"offers":	[{
			"offerId": "'.$arr['offerMappings'][0]['offer']['offerId'].'",
			"quantum": {
				"minQuantity": 1,
				"stepQuantity": 1
				},
				"available": true,
				"vat": 0
			}
		]}';
		$this->restApiRequest($url, $data_json);
	}

	function updateCatalogPorductPrice ($data) {
		$url = $this->cabinetUrl.$this->cabinetId."/offer-prices/updates";
		$arr = json_decode($data, true);
		$discountBase = $arr['basicPrice']/100*110;
		$data_json = '{"offers": [{
			"offerId": "'.$arr['offerMappings'][0]['offer']['offerId'].'",
			"price": {
				"value": '.$arr['basicPrice'].',
				"currencyId": "RUR",
				"discountBase": '.$discountBase.'
			}
		}]}';
		$this->restApiRequest($url, $data_json);
	}
	function updateCatalogPorduct ($data) {
		$data = json_decode($data, true);
		$data = json_encode(['offerMappings' => $data['offerMappings']],  JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		$url = $this->cabinetUrl.$this->cabinetId."/offer-mappings/update";
		$this->restApiRequest($url, $data);
	}

	function getCatalogProductList () {
		$url = $this->cabinetUrl.$this->cabinetId."/offer-mappings?page_token=&limit=20";
		$data = '{
			"offerIds": [],
			"cardStatuses": [],
			"categoryIds": [],
			"vendorNames": [],
			"tags": []
		}';
		$this->restApiRequest($url, $data);
	}


}


?>


