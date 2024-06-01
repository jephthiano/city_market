<?php
if(isset($_GET)){
    require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
    require_once(file_location('inc_path','session_check_nologout.inc.php'));
    if(isset($_SESSION['user_id']) AND isset($u_id)){
        //get available wishlist id
        $or = multiple_content_data('wishlist_table,seller_table,product_table','w_id',$u_id,'u_id',"AND wishlist_table.p_id = product_table.p_id AND product_table.s_id = seller_table.s_id AND seller_table.s_status = 'active' AND product_table.p_status = 'available' ORDER BY w_id DESC LIMIT 0,12");
        if($or !== false){
            ?>
            <div class='j-color6'>
                <div class='j-large j-color1 j-text-color4 j-padding'>Saved Items</div>
                <div>
                    <div class='j-vertical-scroll'>
                        <?php
                        foreach($or AS $id){
                            $p_id = content_data('wishlist_table','p_id',$id,'w_id');
                            show_product($p_id,'horizontal');
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
?>