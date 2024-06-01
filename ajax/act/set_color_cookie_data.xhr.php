<?php
if(isset($_GET['i']) && isset($_GET['c'])){
    require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
    // validating and sanitizing content id
	$id = ($_GET['i']);
	if(empty($id) || !is_numeric($id)){$error[] = "number";}else{$c_id = test_input($id);}
	
    // validating and sanitizing type
	$cl = ($_GET['c']);
	if(empty($cl)){$error[] = "color";}else{$color = strtolower(test_input($cl));}
    
    if(empty($error)){set_color_token($c_id,$color);}
}
?>