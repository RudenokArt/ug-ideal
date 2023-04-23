<?php 

/**
 * 
 */
class Email_subscriptions {
	
	function __construct() {
		$this->subscribers_list = $this->getSubscribersList();
	}

	function addNewSubscriber ($email) {
		$this->subscribers_list[$email] = $email;
		wp_update_post([
			'ID' => $this->post_id,
			'post_content' => json_encode($this->subscribers_list, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
		]);
	}

	function getSubscribersList() {
		$post = get_posts([
			'name' => 'email_subscriptions'
		]);
		$this->post_id = $post[0]->ID;
		$arr = json_decode($post[0]->post_content, true);
		if (!$arr) {
			$arr = [];
		}
		return $arr;
	}

}


?>