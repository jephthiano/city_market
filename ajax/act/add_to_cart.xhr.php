<?php
if(isset($_GET['i']) && isset($_GET['t']) && isset($_GET['c'])){
	require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
	$error = []; $data = [];
	
	if(get_json_data('cart','act') == 0 || get_json_data('all','act') == 0){//if checkout and all act is disabled
		$data["status"] = 'fail';$data["message"] = 'Sorry!!!<br> Cart is not available at the moment';
	}else{
		$token = get_order_token('token');
		// validating and sanitizing content id
		$id = ($_GET['i']);
		if(empty($id) || !is_numeric($id)){$error[] = "number";}else{$c_id = test_input($id);}
		
		// validating and sanitizing type
		$ty = ($_GET['t']);
		if(empty($ty)){$error[] = "type";}else{$type = test_input($ty);}
		
		// validating and sanitizing color
		$cl = ($_GET['c']);
		if(empty($cl) || $cl === 'undefined'){$error[] = "color";}else{$color = strtolower(test_input($cl));}
		
		if(empty($error)){
			$add = " AND p_id = {$c_id} AND or_color = '{$color}' AND or_status = 'cart'";
			$price = content_data('product_table','p_discounted_price',$c_id,'p_id');
			$quantity = content_data('order_table','or_quantity',$token,'or_token',$add);
			$max_order = content_data('product_table','p_max_order',$c_id,'p_id');
			$seller_id = content_data('product_table','s_id',$c_id,'p_id');
			$color_available = get_color_value($c_id,$color);
			if(($quantity >= $max_order || $quantity >= $color_available) && ($type === 'add' || $type === 'buy')){
				$data["status"] = 'fail';$data["message"] = "Sorry!!!<br> The maximum quantity you can order is {$max_order}";
			}else{
				if($quantity === false){ // if no order with same token, p_id and color has been added.... add new one
					$order = new order('admin');
					$order->quantity = 1;
					$order->color = $color;
					$order->delivery_fee = cal_del_fee(1);
					$order->amount = $price;
					$order->order_id = time_token();
					$order->token = $token;
					$order->p_id = $c_id;
					$order->s_id = $seller_id;
					$insert = $order->insert_cart();
					if($insert === true){
						$data["status"] = 'success';$data["message"] = 'Item added to cart';
					}else{
						$data["status"] = 'fail';$data["message"] = 'Sorry!!!<br> Error occur while adding item to cart';
					}
				}elseif($quantity == 1 && $type === 'remove'){ // delete if type is remove and quantity is 1
					$or_id = content_data('order_table','or_id',$token,'or_token',$add);
					$order = new order('admin');
					$order->token = $token;
					$order->id = $or_id;
					$order->status = 'cart';
					$delete = $order->delete_cart();
					if($delete === true){
						$data["status"] = 'success';$data["message"] = 'Item removed from cart';
					}else{
						$data["status"] = 'fail';$data["message"] = 'Sorry!!!<br> Error occur while removing item from cart';
					}
				}elseif($quantity > 0 && ($type === 'add' || $type === 'remove' || $type === 'buy')){ //remove, add, and buy
					$current_amount = content_data('order_table','or_amount',$token,'or_token',$add);
					if($type === 'add' || $type === 'buy'){ // add or buy
						$new_amount = $current_amount + $price;
						$new_quantity = $quantity + 1;
					}elseif($type === 'remove'){ // normal remove
						$new_amount = $current_amount - $price;
						$new_quantity = $quantity - 1;
					}
					$order = new order('admin');
					$order->quantity = $new_quantity;
					$order->color = $color;
					$order->delivery_fee = cal_del_fee($new_quantity);
					$order->amount = $new_amount;
					$order->token = $token;
					$order->p_id = $c_id;
					$update = $order->update_cart();
					if($update === true){
						$data["status"] = 'success';$data["message"] = 'Cart updated';
					}else{
						$data["status"] = 'fail';$data["message"] = 'Sorry!!!<br> Error occur while updating cart';
					}
				}
			}
		}else{
			$data["status"] = 'fail';$data["message"] = 'Sorry!!!<br> Error occur while adding item to cart';
		}//end of if empty
	}
	echo json_encode($data);
}//end of if isset
?>