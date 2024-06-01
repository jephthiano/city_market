<?php
$login = file_location('seller_url','login');
	if(isset($page_url)){ // if page url is set for pages with $_GET
		$redirect = $page_url;
	}else{
		$redirect = file_location('seller_url','');
	}
	header("Location:$login?re=$redirect");
	die();
?>