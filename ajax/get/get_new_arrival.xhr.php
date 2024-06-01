<?php
if(isset($_GET)){
    require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
    ?>
    <?//New Arrival?>
    <div class='j-home-padding'style='margin:15px 0px;'>
        <div class='j-color6'>
            <div class='j-color1'><div class='j-padding j-large'><center><b>New Arrivals</b></center></div></div>
            <div class='j-vertical-scroll'>
                <?php
                $add = "";
                $or = multiple_content_data('product_table,seller_table','p_id','available','p_status',"AND product_table.s_id = seller_table.s_id AND seller_table.s_status = 'active' ORDER BY p_id DESC LIMIT 0,12");
				if($or !== false){
					?><?php
					foreach($or AS $id){show_product($id,'horizontal');}
					?><?php
				}else{
					?><center><br><br><div class='j-text-color3'><b>No new arrival available at the moment</b></div></center><br><br><?php
				}
				?>
            </div>
        </div>
    </div>
    <? //for top deal?>
    <div id='top_deal'><center><br><br><span class='j-text-color1 j-spinner-border j-spinner-border j-large'></span> <br><br></center></div>
    <?php
}
?>