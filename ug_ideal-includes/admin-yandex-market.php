<?php 
include_once __DIR__.'/admin-header.php';
include_once $theme_path.'/ug_ideal-core/YandexMarket.php';
$yaMarketApi = new YandexMarketApi();
// СИНХРОНИЗАЦИЯ С МАРКЕТОМ
// foreach ($yaMarket->getProductList()->posts as $key => $value) {
// 	$yaMarketApi->updateCatalogPorduct($value->post_content);
// }
?>

<pre><?php print_r($yaMarket->getProductList()->posts); ?></pre>
<pre><?php print_r($yaMarketApi->getCatalogProductList()); ?></pre>

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
		$this->cabinetUrl = 'https://api.partner.market.yandex.ru/businesses/';
		
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
		var_dump(json_decode($resp, true));
	}

	function updateCatalogPorduct ($data) {
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

