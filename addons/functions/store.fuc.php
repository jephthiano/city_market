<?php
//STORE FUNCTION STARTS
//function get store starts
function show_store($seller_id,$type='default'){
    $store_name = content_data('seller_table','s_storename',$seller_id,'s_id');
    $joined = content_data('seller_table','s_regdatetime',$seller_id,'s_id');
    if($type === 'default'){
      ?>
      <a href='<?=file_location('home_url','store/'.$store_name.'/')?>'>
       <div class='j-col s3 m3 l2 j-display-container j-clickable j-round'style='padding:8px 8px 8px 8px'>
        <div class='j-color4 j-card-4 j-display-container j-text-color4 j-round j-store-hieght'style="background-image:url('<?=file_location('media_url',get_media('seller',$seller_id))?>');background-size:cover;">
         <div class='j-round j-store-hieght'style='width:100%;background-color:rgba(0,0,0,0.6);'>
          <center><div class='j-medium j-display-middle j-padding'style='width:100%;overflow: hidden;height:35px'><?=ucwords($store_name)?></div></center>
         </div>
        </div>
       </div>
      </a>
      <?php
    }elseif($type === 'seller_page' || $type === 'product_page'){
        ?>
        <div class='j-row j-text-color7'>
			<div class='j-col <?=$type === 'seller_page'?'s3 m2 l1' : 's3 m2 l4'?>'>
                <img class=''src="<?=file_location('media_url',get_media('seller',$seller_id))?>"style='width:100%;height:70px;'/>
            </div>
            <div class='j-col <?=$type === 'seller_page'?'s9 m10 l11' : 's9 m10 l8'?>'style='padding-left:10px;'>
                <div>
                    <span><b><?=ucwords($store_name)?></b></span>
                    <?php
                    if($type === 'product_page'){ ?><span class='j-right'>&#10095</span><?php } ?>
                </div>
                <?php $sold =  get_numrow('order_table','s_id',$seller_id,"return",'round',"AND or_status = 'delivered'");if($sold > 0){$sold = $sold.'+';}else{$sold = 0;}?>
                <span class='j-small'><?=$sold?> Product(s) Sold</span>
                <?php
                if($type === 'seller_page'){
                    ?><span class='j-right'><?php official_store($seller_id)?></span><?php
                }
                ?>
            </div>
        </div>
        <?php // for score rating
        $score = avg_rating($seller_id,'seller');
        if($score < 1){
            $score = 'Not available';
        }else{
            $score = round(($score/5) * 100).'%';
        }
        if($type === 'seller_page'){
           ?>
           <a href='<?=file_location('home_url','review/seller_review/'.addnum($seller_id).'/all/')?>'class='j-text-color7'>
            <span>Seller Rating Score : <b><?=$score?></b></span>
            <span class='j-right'>&#10095</span>
           </a>
           <?php
        }elseif($type === 'product_page'){
            ?><span>Seller Rating Score : <b><?=$score?></b></span><?php
        }
        ?>
        <?php
    }elseif($type === 'rating_page'){
        ?>
        <div style='position:relative;'>
            <div class='j-color7'style='height:90px;'><?php back_btn();?></div>
            <div class='j-padding'style='position:relative;top:-50px'>
                <img class='j-circle j-border-color5 j-border'src="<?=file_location('media_url',get_media('seller',$seller_id))?>"style='width:100px;height:100px;'/>
                <div class='j-bolder j-text-color7 j-large'><?=ucwords($store_name)?></div>
                <div>
                    <span>Joined On: <b><?=showdate($joined,'short')?></b></span>
                    <span class='j-right'><?php official_store($seller_id)?></span>
                </div>
            </div>
        </div>
        <?php
    }
}
//function get store ends

//fucntion official or unofficial store starts
function official_store($id,$type = 'seller',$mode='default'){
    if($type === 'product'){$id =  content_data('product_table','s_id',$id,'p_id');} //get seller id from product id
    $off =  content_data('seller_table','s_type',$id,'s_id');
    if($off === 'official'){
        if($mode === 'default'){
            ?>
            <span class='j-padding j-round-large j-border-2 j-border-color5 j-card-4 j-color2'>
                <span class='j-small j-center'><b>Official Store</b></span>
            </span>
            <?php
        }else{
            ?>
            <span class='j-round j-color2 j-padding-tiny'style='padding: 2px 6px;'>
                <span class='j-tiny j-center'><b>Official Store</b></span>
            </span>
            <?php
        }
    }
}
//fucntion official or unofficial store ends
//STORE FUNCTION ENDS
?>