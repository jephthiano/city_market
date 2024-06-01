<?php
class product{
    private $table = 'product_table';
    private $media_table = 'product_media_table';
    private $dbconn;
	private $dbstmt;
	private $dbsql;
    private $dbnumRow;
    
    public $id;
    public $name;
    public $brand;
    public $category;
    public $sub_category;
    public $max_order;
    public $original_price;
    public $discounted_price;
    public $color;
    public $content;
    public $details;
    public $status;
    public $weight;
    public $s_id;
    
    
    
    public $type;
    public $file_length;
    public $arr_file_name;
    public $arr_extension;
    public $pm_id;
    public $file_name;
    public $extension;
    
    private $current_admin;
    private $last_id;
    private $full_file_name;
    private $full_path;
    
    public function __construct($conn = ''){
        if(!empty($conn)){
            //CREATE CONNECTION
            require_once(file_location('inc_path','connection.inc.php'));
            $this->dbconn = dbconnect($conn,'PDO');
        }
        require_once(file_location('inc_path','class_all_session.inc.php'));
        $this->current_admin = all_session('admin');
        $this->current_seller = all_session('seller');
        $this->current_user = all_session('user');
    }
    
    public function __destruct(){
    	//CLOSES ALL CONNECTION
        if(is_resource($this->dbconn)){
            closeconnect('db', $this->dbconn);
        }
        if(is_resource($this->dbstmt)){
            closeconnect('stmt',$this->dbstmt);
        }
    }
    
    
    public function insert_product(){
        if(content_data('product_table','p_id',$this->name,'p_name',"AND s_id = {$this->current_seller} AND p_status IN ('pending','available','unavailable')") !== false){
            if($this->type === 'normal'){
                //delete image
                for($x = 0; $x < $this->file_length; $x++){
                    $this->full_file_name = $this->arr_file_name[$x].".".$this->arr_extension[$x];
                    $this->full_path = file_location('media_path','product/'.$this->full_file_name);
                    if(file_exists($this->full_path) && $this->full_file_name !== 'home/no_media.png' && is_file($this->full_path)){unlink($this->full_path);}
                }
            }
            return 'exists';
        }else{
            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            try{
                //begin transaction
                $this->dbconn->beginTransaction();
                $this->dbsql = "INSERT INTO {$this->table}(p_name,p_brand,p_category,p_sub_category,p_max_order,p_original_price,p_discounted_price,p_color,p_content,p_details,p_weight,s_id)
                VALUES(:name,:brand,:category,:sub_category,:max_order,:original_price,:discounted_price,:color,:content,:details,:weight,:s_id)";
                $this->dbstmt = $this->dbconn->prepare($this->dbsql);
                $this->dbstmt->bindParam(':name',$this->name,PDO::PARAM_STR);
                $this->dbstmt->bindParam(':brand',$this->brand,PDO::PARAM_STR);
                $this->dbstmt->bindParam(':category',$this->category,PDO::PARAM_STR);
                $this->dbstmt->bindParam(':sub_category',$this->sub_category,PDO::PARAM_STR);
                $this->dbstmt->bindParam(':max_order',$this->max_order,PDO::PARAM_STR);
                $this->dbstmt->bindParam(':original_price',$this->original_price,PDO::PARAM_STR);
                $this->dbstmt->bindParam(':discounted_price',$this->discounted_price,PDO::PARAM_STR);
                $this->dbstmt->bindParam(':color',$this->color,PDO::PARAM_STR);
                $this->dbstmt->bindParam(':content',$this->content,PDO::PARAM_STR);
                $this->dbstmt->bindParam(':details',$this->details,PDO::PARAM_STR);
                $this->dbstmt->bindParam(':weight',$this->weight,PDO::PARAM_INT);
                $this->dbstmt->bindParam(':s_id',$this->current_seller,PDO::PARAM_INT);
                $this->dbstmt->execute();
                $this->last_id = $this->dbconn->lastInsertId(); //last id
                if($this->type === 'normal' && $this->file_length === count($this->arr_file_name) && $this->file_length === count($this->arr_extension)){
                    // insert image
                    for($x = 0; $x < $this->file_length; $x++){
                        $this->dbsql = "INSERT INTO {$this->media_table}(pm_link_name,pm_extension,p_id) VALUES(:link_name,:extension,:p_id)";
                        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
                        $this->dbstmt->bindParam(':link_name',$this->arr_file_name[$x],PDO::PARAM_STR);
                        $this->dbstmt->bindParam(':extension',$this->arr_extension[$x],PDO::PARAM_STR);
                        $this->dbstmt->bindParam(':p_id',$this->last_id,PDO::PARAM_INT);
                        $this->dbstmt->execute();
                    }
                }
                // commit the transation
                if($this->dbconn->commit()){return $this->last_id;}//if commit
            }catch(PDOException $e){
                //rollback
                if($this->dbconn->rollback()){
                    if($this->type === 'normal'){
                        //delete image
                        for($x = 0; $x < $this->file_length; $x++){
                            $this->full_file_name = $this->arr_file_name[$x].".".$this->arr_extension[$x];
                            $this->full_path = file_location('media_path','product/'.$this->full_file_name);
                            if(file_exists($this->full_path) && $this->full_file_name !== 'home/no_media.png' && is_file($this->full_path)){unlink($this->full_path);}
                        }
                    }
                    return false;
                }//if rollback
            }// end of try and catch
        }
    }//end insert product
    
    public function update_product(){
        $this->dbsql = "UPDATE {$this->table} SET p_name = :name,p_brand = :brand,p_category = :category,p_sub_category = :sub_category,
        p_max_order = :max_order,p_original_price = :original_price,
        p_discounted_price = :discounted_price,p_color = :color,p_content = :content,
        p_details = :details,p_weight = :weight WHERE p_id = :id LIMIT 1";
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':name',$this->name,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':brand',$this->brand,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':category',$this->category,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':sub_category',$this->sub_category,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':max_order',$this->max_order,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':original_price',$this->original_price,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':discounted_price',$this->discounted_price,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':color',$this->color,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':content',$this->content,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':details',$this->details,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':weight',$this->weight,PDO::PARAM_INT);
        $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
        if($this->dbstmt->execute()){return true;}else{return false;} 
    }
    
    public function change_status(){
        $this->dbsql = "UPDATE {$this->table} SET p_status = :status WHERE p_id = :id LIMIT 1";
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
        $this->dbstmt->bindParam(':status',$this->status,PDO::PARAM_STR);
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){return true;}else{return false;} 
    }
    
    public function delete_product(){
        $this->status = 'deleted';
        $this->dbsql = "UPDATE {$this->table} SET p_status = :status WHERE p_id = :id LIMIT 1";
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
        $this->dbstmt->bindParam(':status',$this->status,PDO::PARAM_STR);
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){return true;}else{return false;} 
    }
    
    public function remove_image(){
        $this->full_file_name = get_media('product',$this->pm_id);
        $this->full_path = file_location('media_path',$this->full_file_name);
        if(file_exists($this->full_path) && $this->full_file_name !== 'home/no_media.png' && is_file($this->full_path)){
                if(unlink($this->full_path)){
                    $this->dbsql = "DELETE FROM {$this->media_table} WHERE pm_id = :id LIMIT 1";
                    $this->dbstmt = $this->dbconn->prepare($this->dbsql);
                    $this->dbstmt->bindParam(':id',$this->pm_id,PDO::PARAM_INT);
                    $this->dbstmt->execute();
                    return true;
                }else{
                    return false;
                }
        }
    }
    
    public function change_image(){
        $this->full_file_name = get_media('product',$this->pm_id);
        $this->full_path = file_location('media_path',$this->full_file_name);
        $exists = content_data($this->media_table,'pm_id',$this->pm_id,'pm_id');
        if($exists !== false){
            $this->dbsql = "UPDATE {$this->media_table} SET pm_link_name = :link_name,pm_extension = :extension WHERE pm_id = :pm_id LIMIT 1";
        }else{
            $this->dbsql = "INSERT INTO {$this->media_table}(pm_link_name,pm_extension,p_id)VALUES(:link_name,:extension,:id)";
        }
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':link_name',$this->file_name,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':extension',$this->extension,PDO::PARAM_STR);
        if($exists !== false){$this->dbstmt->bindParam(':pm_id',$this->pm_id,PDO::PARAM_INT);}else{$this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);}
        if($this->dbstmt->execute()){
            //delete the existing image
            if(file_exists($this->full_path) && $this->full_file_name !== 'home/no_media.png' && is_file($this->full_path)){unlink($this->full_path);}
            return true;
        }else{
            //delete new image
            $this->full_file_name = $this->file_name.".".$this->extension;
            $this->full_path = file_location('media_path','product/'.$this->full_file_name);
            if(file_exists($this->full_path) && $this->full_file_name !== 'home/no_media.png' && is_file($this->full_path)){unlink($this->full_path);}
            return false;
        }
    }//end of store user image
}
?>