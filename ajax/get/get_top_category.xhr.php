<?php
if(isset($_GET)){
    require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
    ?>
    <?//Top category?>
    <div class='j-home-padding'style='margin:15px 0px;'>
        <div class='j-color4'>
            <div class='j-color3'><div class='j-padding j-large'><center><b>Top Categories</b></center></div></div>
            <div class='j-row'>
                <?php
                //GET THE CATEGORY
                // creating connection
                require_once(file_location('inc_path','connection.inc.php'));
                @$conn = dbconnect('admin','PDO');
                $sql = "SELECT order_table.p_id,COUNT(order_table.p_id) as total from order_table,product_table,seller_table
                WHERE product_table.p_id = order_table.p_id AND p_status = 'available' AND order_table.s_id = seller_table.s_id AND seller_table.s_status = 'active'
                GROUP BY order_table.p_id ORDER BY total DESC LIMIT 12";
                $stmt = $conn->prepare($sql);
                $stmt->bindColumn('p_id',$id);
                $stmt->execute();
                $numRow = $stmt->rowCount();
                $data = [];
                if($numRow > 0){
                    while($stmt->fetch()){$data[] = content_data('product_table','p_category',$id,'p_id');}
                    $data = array_unique($data);
                    $data = re_key_array($data);
                    $total = count($data);
                    //ECHO THE GOTTEN CATEGORY
                    $category_data = '';
                    for($i = 0; $i < $total; $i++){
                        get_category($data[$i],'home_data');
                        if($i == ($total-1)){$category_data .= "'".$data[$i]."'";}else{$category_data .= "'".$data[$i]."',";}// dont add , for the last one
                    }
                }else{
                    $total = 0;
                }
                //IF THE CATEGORY IS NOT UP TO 12
                if($total < 12){ // if top category is not up to 12
                    $rem = (12 - $total);
                    if($total === 0){$category_data = "'unknown'";}
                    $sql = "SELECT DISTINCT p_category FROM product_table,seller_table
                    WHERE p_category NOT IN ({$category_data}) AND product_table.s_id = seller_table.s_id AND seller_table.s_status = 'active'
                    ORDER BY RAND() LIMIT 0,{$rem}";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindColumn('p_category',$category);
                    $stmt->execute();
                    $numRow = $stmt->rowCount();
                    if($numRow > 0){while($stmt->fetch()){get_category($category,'home_data');}}
                }
                ?>
                <? //for all?>
                <a href='<?=file_location('home_url','category/')?>'>
                <div class='j-col s6 m4 l3 xl3 j-padding j-section j-display-container j-clickable j-round'>
					<div class='j-color4 j-card-4 j-display-container j-text-color4 j-round'style="height:150px;background-image:url('<?=file_location('media_url','category/all.png')?>');background-size:cover;">
                        <div class='j-display-bottommiddle j-round'style='width:100%;background-color:rgba(0,0,0,0.7);min-height:30px;'>
                            <center><div class='j-medium'><b>See All Category</b></div></center>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
    <? //for top store?>
    <div id='top_store'><center><br><br><span class='j-text-color1 j-spinner-border j-spinner-border j-large'></span> <br><br></center></div>
    <?php
}
?>