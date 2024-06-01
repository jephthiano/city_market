<div class='j-padding'>
    <div class='j-large j-bolder j-vertical-scroll'>
        <?php
        if($user === "admin"){
            $url = file_location('admin_url','order/user_all_orders/'.addnum($u_id).'/');
            $request_type = 'user';
        }elseif($user === 'seller'){
            $url = file_location('seller_url','order/');
            $u_id = $slid;
            $request_type = 'seller';
        }elseif($user === 'user'){
            $url = file_location('home_url','order/');
            $request_type = 'user';
        }
        ?>
        <div class=""style="padding:10px 0px;">
            <a href='<?=$url?>order placed/'>
            <span class="j-padding <?=$type === 'order placed'?'j-text-color1':'j-text-color5';?>" style="<?php if($type === 'order placed'){echo 'border-bottom:solid 3px'.get_json_data('primary_color','color');}?>">
            Order placed (<?=get_order_numrow("'order placed'",$u_id,'return','round','',$request_type)?>)
            </span>
            </a>
            <a href='<?=$url?>in-transit/'>
            <span class="j-padding <?=$type === 'in-transit'?'j-text-color1':'j-text-color5';?>" style="<?php if($type === 'in-transit'){echo 'border-bottom:solid 3px'.get_json_data('primary_color','color');}?>">
            In-transit (<?=get_order_numrow("'confirmed','in-transit','packaging','ready-for-pickup'",$u_id,'return','round','',$request_type)?>)
            </span>
            </a>
            <a href='<?=$url?>delivered/'>
            <span class="j-padding <?=$type === 'delivered'?'j-text-color1':'j-text-color5';?>" style="<?php if($type === 'delivered'){echo 'border-bottom:solid 3px'.get_json_data('primary_color','color');}?>">
            Delivered (<?=get_order_numrow("'delivered'",$u_id,'return','round','',$request_type)?>)
            </span>
            </a><a href='<?=$url?>unsuccessful/'>
            <span class="j-padding <?=$type === 'unsuccessful'?'j-text-color1':'j-text-color5';?>" style="<?php if($type === 'unsuccessful'){echo 'border-bottom:solid 3px'.get_json_data('primary_color','color');}?>">
            Unsuccessful (<?=get_order_numrow("'failed','cancelled','failed delivery','returned'",$u_id,'return','round','',$request_type)?>)
            </span>
            </a>
        </div>
    </div>
    <div>
        <?php require_once(file_location('inc_path','product_pagination.inc.php')); //order pagination?>
        </div>
</div>