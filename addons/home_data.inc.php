<?//3tiers?>
<div class='j-home-padding'style='margin:15px 0px;'>
	<div class='j-row j-center'>
		<center>
			<div class='j-col s4 m3 j-padding-small'>
				<div class='j-color4 j-padding-small j-card j-round'style='height:80px;overflow-x: hidden;'>
					<div class='j-center j-text-color5 j-xlarge'><i class='<?=icon('truck')?>'></i></div>
					<div class='j-small'>Home Delivery</div>
				</div>
			</div>
			<div class='j-col s4 m3 j-padding-small'>
				<div class='j-color4 j-padding-small j-card j-round'style='height:80px;overflow-x: hidden;'>
					<div class='j-center j-text-color5 j-xlarge'><i class='<?=icon('shield-alt')?>'></i></div>
					<div class='j-small'>100% Secure Payment</div>
				</div>
			</div>
			<div class='j-col s4 m3 j-padding-small'>
				<div class='j-color4 j-padding-small j-card j-round'style='height:80px;overflow-x: hidden;'>
					<div class='j-center j-text-color5 j-xlarge'><i class='<?=icon('handshake')?>'></i></div>
					<div class='j-small'>24/7 Support</div>
				</div>
			</div>
			<div class='j-col s4 m3 j-padding-small j-hide-small'>
				<div class='j-color4 j-padding-small j-card j-round'style='height:80px;overflow-x: hidden;'>
					<div class='j-center j-text-color5 j-xlarge'><i class='<?=icon('credit-card')?>'></i></div>
					<div class='j-small'>7 days return policy</div>
				</div>
			</div>
		</center>
	</div>
</div>

<?//flash sale?>
<div class='j-home-padding'style='margin:15px 0px;'>
    <div class='j-color4'>
        <div class='j-color5'><div class='j-padding j-large'><b>Flash Sale</b></div></div>
        <div class='j-row j-color6'>
            <?php
			// creating connection
            require_once(file_location('inc_path','connection.inc.php'));
            @$conn = dbconnect('admin','PDO'); 
            $sql = "SELECT p_id,(100-(p_original_price - p_discounted_price)*100) as discount FROM product_table,seller_table
			WHERE p_status = 'available' AND product_table.s_id = seller_table.s_id AND seller_table.s_status = 'active'
			ORDER BY discount ASC LIMIT 24";
            $stmt = $conn->prepare($sql);
            $stmt->bindColumn('p_id',$id);
            $stmt->execute();
            $numRow = $stmt->rowCount();
			if($numRow > 0){
				while($stmt->fetch()){show_product($id,'home');}
			}else{
				?><center><br><br><div class='j-text-color3'><b>No flash sale available at the moment</b></div></center><br><br><?php
			}
			?>
        </div>
    </div>
</div>
	
<? //for new arrival?>
<div id='new_arrival'><center><br><br><span class='j-text-color1 j-spinner-border j-spinner-border j-large'></span> <br><br></center></div>