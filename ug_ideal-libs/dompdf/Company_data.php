<?php
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
$company_data = new Company_data();


/**
 * 
 */
class Company_data {
	
	function __construct() {

		// $this->company_category = get_category_by_slug('company_contacts');

		$this->company_name = get_posts([
			'category_name' => 'company_contacts',
			'name' => 'company_name',
		])[0]->post_content;

		$this->work_time = get_posts([
			'work_time' => 'work_time',
			'name' => 'work_time',
		])[0]->post_content;

		$this->company_address = json_decode(get_posts([
			'category_name' => 'company_contacts',
			'name' => 'company_address',
		])[0]->post_content);

		$this->company_email = json_decode(get_posts([
			'category_name' => 'company_contacts',
			'name' => 'company_email',
		])[0]->post_content);

		$this->company_phones = json_decode(get_posts([
			'category_name' => 'company_contacts',
			'name' => 'company_phones',
		])[0]->post_content);

		$this->social_networks = json_decode(get_posts([
			'category_name' => 'company_contacts',
			'name' => 'social_networks',
		])[0]->post_content);

		$this->company_address_html = $this->htmlHelper($this->company_address);
		$this->company_email_html = $this->htmlHelper($this->company_email);
		$this->company_phones_html = $this->htmlHelper($this->company_phones);
	}

	function htmlHelper ($arr) {
		$str = '';
		foreach ($arr as $key => $value) {
			$str = $str.$value.'<br>';
		}
		return $str;
	}

}

