<?php
class category{
    private $table = 'category_table';
    private $table2 = 'product_table';
    private $table3 = 'sub_category_table';
    private $media_table = 'category_media_table';
    private $media_table2 = 'sub_category_media_table';
    private $dbconn;
	private $dbstmt;
	private $dbsql;
    private $dbnumRow;
    
    public $id;
    public $category;
    public $icon;
    public $old_category;
    
    public $sc_id;
    public $sc_subcategory;
    public $sc_icon;
    
    public $type;
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
    
    
    public function insert_category(){
        if(content_data('category_table','c_id',$this->category,'c_category') !== false){
            if($this->type === 'normal'){
                //delete image recently uploaded if content exists
                $this->full_file_name = $this->file_name.".".$this->extension;
                $this->full_path = file_location('media_path','category/'.$this->full_file_name);
                if(file_exists($this->full_path) && $this->full_file_name !== 'home/no_media.png' && is_file($this->full_path)){unlink($this->full_path);}
            }
            return 'exists';
        }else{
            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            try{
                //begin transaction
                $this->dbconn->beginTransaction();
                $this->dbsql = "INSERT INTO {$this->table}(c_category,c_icon)VALUES(:category,:icon)";
                $this->dbstmt = $this->dbconn->prepare($this->dbsql);
                $this->dbstmt->bindParam(':category',$this->category,PDO::PARAM_STR);
                $this->dbstmt->bindParam(':icon',$this->icon,PDO::PARAM_STR);
                $this->dbstmt->execute();
                $this->last_id = $this->dbconn->lastInsertId(); //last id
                if($this->type === 'normal'){
                    // insert image
                    $this->dbsql = "INSERT INTO {$this->media_table}(cm_link_name,cm_extension,c_id) VALUES(:link_name,:extension,:c_id)";
                    $this->dbstmt = $this->dbconn->prepare($this->dbsql);
                    $this->dbstmt->bindParam(':link_name',$this->file_name,PDO::PARAM_STR);
                    $this->dbstmt->bindParam(':extension',$this->extension,PDO::PARAM_STR);
                    $this->dbstmt->bindParam(':c_id',$this->last_id,PDO::PARAM_INT);
                    $this->dbstmt->execute();
                }
                // commit the transation
                if($this->dbconn->commit()){return $this->last_id;}//if commit
            }catch(PDOException $e){
                //rollback
                if($this->dbconn->rollback()){
                    if($this->type === 'normal'){
                        //delete image
                        $this->full_file_name = $this->file_name.".".$this->extension;
                        $this->full_path = file_location('media_path','category/'.$this->full_file_name);
                        if(file_exists($this->full_path) && $this->full_file_name !== 'home/no_media.png' && is_file($this->full_path)){unlink($this->full_path);}
                    }
                    return false;
                }//if rollback
            }// end of try and catch
        }
    }//end insert category
    
    public function update_category(){
        $this->old_category = content_data('category_table','c_category',$this->id,'c_id');
        
        $this->dbconn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        try{
            //begin transaction
            $this->dbconn->beginTransaction();
            //update category in category
            $this->dbsql = "UPDATE {$this->table} SET c_category = :category,c_icon = :icon  WHERE c_id = :id LIMIT 1";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':category',$this->category,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':icon',$this->icon,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
            $this->dbstmt->execute();
            // commit the transation
            if($this->dbconn->commit()){return true;}//if commit
        }catch(PDOException $e){
            //rollback
            if($this->dbconn->rollback()){return false;}//if rollback
        }// end of try and catch
    }
    
    public function insert_subcategory(){
        $cid = content_data('sub_category_table','sc_id',$this->id,'c_id');
        $sub_category = content_data('sub_category_table','sc_id',$this->sc_subcategory,'sc_sub_category');
        if(($cid !== false) && ($sub_category !== false)){
            if($this->type === 'normal'){
                //delete image recently uploaded if content exists
                $this->full_file_name = $this->file_name.".".$this->extension;
                $this->full_path = file_location('media_path','subcategory/'.$this->full_file_name);
                if(file_exists($this->full_path) && $this->full_file_name !== 'home/no_media.png' && is_file($this->full_path)){unlink($this->full_path);}
            }
            return 'exists';
        }else{
            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            try{
                //begin transaction
                $this->dbconn->beginTransaction();
                $this->dbsql = "INSERT INTO {$this->table3}(sc_sub_category,sc_icon,c_id)VALUES(:subcategory,:icon,:id)";
                $this->dbstmt = $this->dbconn->prepare($this->dbsql);
                $this->dbstmt->bindParam(':subcategory',$this->sc_subcategory,PDO::PARAM_STR);
                $this->dbstmt->bindParam(':icon',$this->sc_icon,PDO::PARAM_STR);
                $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
                $this->dbstmt->execute();
                $this->last_id = $this->dbconn->lastInsertId(); //last id
                if($this->type === 'normal'){
                    // insert image
                    $this->dbsql = "INSERT INTO {$this->media_table2}(scm_link_name,scm_extension,sc_id) VALUES(:link_name,:extension,:sc_id)";
                    $this->dbstmt = $this->dbconn->prepare($this->dbsql);
                    $this->dbstmt->bindParam(':link_name',$this->file_name,PDO::PARAM_STR);
                    $this->dbstmt->bindParam(':extension',$this->extension,PDO::PARAM_STR);
                    $this->dbstmt->bindParam(':sc_id',$this->last_id,PDO::PARAM_INT);
                    $this->dbstmt->execute();
                }
                // commit the transation
                if($this->dbconn->commit()){return $this->last_id;}//if commit
            }catch(PDOException $e){
                //rollback
                if($this->dbconn->rollback()){
                    if($this->type === 'normal'){
                        //delete image
                        $this->full_file_name = $this->file_name.".".$this->extension;
                        $this->full_path = file_location('media_path','subcategory/'.$this->full_file_name);
                        if(file_exists($this->full_path) && $this->full_file_name !== 'home/no_media.png' && is_file($this->full_path)){unlink($this->full_path);}
                    }
                    return false;
                }//if rollback
            }// end of try and catch
        }
    }//end insert subcategory
    
    public function update_subcategory(){
        $this->dbconn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        try{
            //begin transaction
            $this->dbconn->beginTransaction();
            //update category in category
            $this->dbsql = "UPDATE {$this->table3} SET sc_sub_category = :category,sc_icon = :icon  WHERE sc_id = :id LIMIT 1";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':category',$this->category,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':icon',$this->icon,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
            $this->dbstmt->execute();
            // commit the transation
            if($this->dbconn->commit()){return true;}//if commit
        }catch(PDOException $e){
            //rollback
            if($this->dbconn->rollback()){return false;}//if rollback
        }// end of try and catch
    }
    
    public function delete_category($type){
        $this->category = 0;
        $this->full_file_name = get_media($type,$this->id);
        $this->old_category = $this->id;
        
        $this->dbconn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        try{
            //begin transaction
            $this->dbconn->beginTransaction();
            if($type === 'category'){
                //delete category in product
                $this->dbsql = "DELETE FROM {$this->table} WHERE c_id = :id LIMIT 1";
                $this->dbstmt = $this->dbconn->prepare($this->dbsql);
                $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
                $this->dbstmt->execute();
            }elseif($type === 'subcategory'){
                //delete category in product
                $this->dbsql = "DELETE FROM {$this->table3} WHERE sc_id = :id LIMIT 1";
                $this->dbstmt = $this->dbconn->prepare($this->dbsql);
                $this->dbstmt->bindParam(':id',$this->sc_id,PDO::PARAM_INT);
                $this->dbstmt->execute();
            }
            //update category in product table
            $this->update_product_category($type);
            // commit the transation
            if($this->dbconn->commit()){
                $this->full_path = file_location('media_path',$this->full_file_name);
                if(file_exists($this->full_path) && $this->full_file_name !== 'home/no_media.png'){
                    unlink($this->full_path);
                }
                return true;
            }//if commit
        }catch(PDOException $e){
            //rollback
            if($this->dbconn->rollback()){return false;}//if rollback
        }// end of try and catch
    }
    
    public function update_product_category($type){
        //change product sub category
        $this->dbsql = "UPDATE {$this->table2} SET p_sub_category = :category WHERE p_category = :old_category";
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':category',$this->category,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':old_category',$this->old_category,PDO::PARAM_STR);
        $this->dbstmt->execute();
        //change product category
        if($type === 'category'){            
            $this->dbsql = "UPDATE {$this->table2} SET p_category = :category WHERE p_category = :old_category";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':category',$this->category,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':old_category',$this->old_category,PDO::PARAM_STR);
            $this->dbstmt->execute();
        }
    }
    
    public function remove_image($type){
        $this->full_file_name = get_media($type,$this->id);
        $this->full_path = file_location('media_path',$this->full_file_name);
        if(file_exists($this->full_path) && $this->full_file_name !== 'home/no_media.png' && is_file($this->full_path)){
                if(unlink($this->full_path)){
                    if($type === 'category'){
                        $this->dbsql = "DELETE FROM {$this->media_table} WHERE c_id = :id LIMIT 1";   
                    }elseif($type === 'subcategory'){
                        $this->dbsql = "DELETE FROM {$this->media_table2} WHERE sc_id = :id LIMIT 1";   
                    }
                    $this->dbstmt = $this->dbconn->prepare($this->dbsql);
                    $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
                    $this->dbstmt->execute();
                    return true;
                }else{
                    return false;
                }
        }
    }
    public function change_image(){
        $this->full_file_name = get_media('category',$this->id);
        $this->full_path = file_location('media_path',$this->full_file_name);
        
        if(content_data($this->media_table,'cm_id',$this->id,'c_id') !== false){
            $this->dbsql = "UPDATE {$this->media_table} SET cm_link_name = :link_name,cm_extension = :extension WHERE c_id = :id LIMIT 1";
        }else{
            $this->dbsql = "INSERT INTO {$this->media_table}(cm_link_name,cm_extension,c_id)VALUES(:link_name,:extension,:id)";
        }
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':link_name',$this->file_name,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':extension',$this->extension,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
        if($this->dbstmt->execute()){
            //delete the existing image
            if(file_exists($this->full_path) && $this->full_file_name !== 'home/no_media.png' && is_file($this->full_path)){unlink($this->full_path);}
            return true;
        }else{
            //delete new image
            $this->full_file_name = $this->file_name.".".$this->extension;
            $this->full_path = file_location('media_path','category/'.$this->full_file_name);
            if(file_exists($this->full_path) && $this->full_file_name !== 'home/no_media.png' && is_file($this->full_path)){unlink($this->full_path);}
            return false;
        }
    }//end of change category image
    
    public function change_subcategory_image(){
        $this->full_file_name = get_media('subcategory',$this->id);
        $this->full_path = file_location('media_path',$this->full_file_name);
        
        if(content_data($this->media_table2,'scm_id',$this->id,'sc_id') !== false){
            $this->dbsql = "UPDATE {$this->media_table2} SET scm_link_name = :link_name,scm_extension = :extension WHERE sc_id = :id LIMIT 1";
        }else{
            $this->dbsql = "INSERT INTO {$this->media_table2}(scm_link_name,scm_extension,sc_id)VALUES(:link_name,:extension,:id)";
        }
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':link_name',$this->file_name,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':extension',$this->extension,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
        if($this->dbstmt->execute()){
            //delete the existing image
            if(file_exists($this->full_path) && $this->full_file_name !== 'home/no_media.png' && is_file($this->full_path)){unlink($this->full_path);}
            return true;
        }else{
            //delete new image
            $this->full_file_name = $this->file_name.".".$this->extension;
            $this->full_path = file_location('media_path','subcategory/'.$this->full_file_name);
            if(file_exists($this->full_path) && $this->full_file_name !== 'home/no_media.png' && is_file($this->full_path)){unlink($this->full_path);}
            return false;
        }
    }//end of subcategory image
}
?>