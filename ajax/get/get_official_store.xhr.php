<?php
if(isset($_GET)){
    require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
    ?>
    <?//Top Deal?>
    <div class='j-home-padding'style='margin:15px 0px;'>
        <div class='j-color4'>
            <div class='j-text-color4'style='background-color:teal'><div class='j-padding j-large'><b>Official Stores</b></div></div>
            <div class='j-row'>
                <?php
                // creating connection
                require_once(file_location('inc_path','connection.inc.php'));
                @$conn = dbconnect('admin','PDO');
                $sql = "SELECT seller_table.s_id FROM seller_table,product_table
                WHERE s_type = 'official' AND s_status = 'active' AND product_table.s_id = seller_table.s_id ORDER BY RAND() LIMIT 0,12";
                $stmt = $conn->prepare($sql);
                $stmt->bindColumn('s_id',$id);
                $stmt->execute();
                $numRow = $stmt->rowCount();
                if($numRow > 0){
                    while($stmt->fetch()){show_store($id,'default');}
                }else{
                    ?><center><br><br><div class='j-text-color3'><b>Oops!!! No official store can be fecthed at the moment</b></div></center><br><br><?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}
?>