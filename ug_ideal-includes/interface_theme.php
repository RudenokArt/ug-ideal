<?php
	$interface_theme = json_decode(get_posts([
			'category_name' => 'company_contacts',
			'name' => 'theme_manager', 
		])[0]->post_content, true);
?>


<style>
	
.theme_color {
	background: <?php echo $interface_theme['theme_color'];?> !important;
	background-color: <?php echo $interface_theme['theme_color'];?> !important;
}

.text_color {
	color: <?php echo $interface_theme['text_color'];?> !important;
}

</style>