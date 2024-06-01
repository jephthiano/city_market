<?php
class seller{
    private $table = 'seller_table';
    private $table2 = 'seller_contact_table';
    private $table3 = 'seller_account_table';
    private $table4 = 'seller_request_table';
    private $product_table = 'product_table';
    private $media_table = 'seller_media_table';
    private $dbconn;
	private $dbstmt;
	private $dbsql;
    private $dbnumRow;
    
    public $id;
    public $email;
    public $fullname;
    public $storename;
    public $password;
    public $status;
    public $registered_by;
    
    public $sc_id;
    public $address;
    public $phnumber1;
    public $phnumber2;
    
    public $new_email;
    public $new_storename;
    public $new_password;
    
    public $type;
    public $file_name;
    public $extension;
    
    private $current_seller;
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
    
    public function re_hash_pass(){
        $this->new_password = hash_pass($this->current_password);
        $this->dbsql = "UPDATE {$this->table} SET s_password = :password WHERE s_storename = :storename LIMIT 1";
        $this->dbstmt =  $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':password',$this->new_password,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':storename',$this->storename,PDO::PARAM_STR);
        $this->dbstmt->execute();
    }
    
    public function authenticate_login(){
        //check if seller exists
        $this->id = content_data($this->table,'s_id',$this->storename,'s_storename',"AND s_status IN ('active','suspended')");
        if($this->id !== false){
            $this->status = content_data($this->table,'s_status',$this->id,'s_id');
            $this->password = content_data($this->table,'s_password',$this->id,'s_id');
            if(password_verify($this->current_password,$this->password)){// verify
                if(password_needs_rehash($this->password,PASSWORD_DEFAULT)){$this->re_hash_pass();}//end of if need rehash
                if($this->status === "suspended"){return 'suspended';}elseif($this->status === "active"){return $this->id;}
            }else{//if password doesnt match
                return false;
            }//end of if passowrd match
        }else{// if user does not exits
            return false;
        }
    }// end of authenticate_login
    
    
    public function log_out(){
     require_once(file_location('seller_inc_path','session_destroy.inc.php'));
     return true;
    }
    
    public function register_seller(){
        $this->dbconn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        try{
            //begin transaction
            $this->dbconn->beginTransaction();
            //insert seller details
            $this->dbsql = "INSERT INTO {$this->table}(s_email,s_fullname,s_storename,s_type,s_password,ad_registered_by)
            VALUES(:email,:fullname,:storename,:type,:password,:registered_by)";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':email',$this->email,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':fullname',$this->fullname,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':storename',$this->storename,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':type',$this->type,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':password',$this->password,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':registered_by',$this->registered_by,PDO::PARAM_INT);
            $this->dbstmt->execute();
            $this->last_id = $this->dbconn->lastInsertId(); //last id
            
            // insert seller conatct details
            $this->dbsql = "INSERT INTO {$this->table2}(sc_address,sc_phnumber1,sc_phnumber2,s_id)
            VALUES(:address,:phnumber1,:phnumber2,:sid)";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':address',$this->address,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':phnumber1',$this->phnumber1,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':phnumber2',$this->phnumber2,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':sid',$this->last_id,PDO::PARAM_INT);
            $this->dbstmt->execute();
            
            // commit the transation
            if($this->dbconn->commit()){return $this->last_id;}//if commit
        }catch(PDOException $e){
            //rollback
            if($this->dbconn->rollback()){return false;}//if rollback
        }// end of try and catch
    }//end insert seller
    
    public function insert_seller_bank_details(){
        $this->dbsql = "INSERT INTO {$this->table3}(sa_name,sa_number,sa_bank,s_id)
        VALUES(:account_name,:account_number,:bank_name,:sid)";
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':account_name',$this->account_name,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':account_number',$this->account_number,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':bank_name',$this->bank_name,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':sid',$this->current_seller,PDO::PARAM_INT);
        if($this->dbstmt->execute()){return $this->dbconn->lastInsertId();}else{return false;} 
    }//end insert seller bank details
    
    public function insert_seller_request(){
        $this->dbsql = "INSERT INTO {$this->table4}(sr_type,sr_details,s_id)
        VALUES(:type,:details,:sid)";
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':type',$this->type,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':details',$this->details,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':sid',$this->current_seller,PDO::PARAM_INT);
        if($this->dbstmt->execute()){return $this->dbconn->lastInsertId();}else{return false;} 
    }//end insert seller request
    
    public function insert_become_seller_data(){
        $this->type = 'become seller';
        $this->dbsql = "INSERT INTO {$this->table4}(sr_type,sr_name,sr_email,sr_phnumber,sr_details)
        VALUES(:type,:name,:email,:phnumber,:details)";
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':type',$this->type,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':name',$this->name,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':email',$this->email,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':phnumber',$this->phnumber,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':details',$this->details,PDO::PARAM_STR);
        if($this->dbstmt->execute()){return $this->dbconn->lastInsertId();}else{return false;} 
    }//end insert seller request
    
    public function update_seller_data(){
        $this->dbsql = "UPDATE {$this->table} SET s_email = :email,s_fullname = :fullname,s_storename = :storename
        WHERE s_id = :id LIMIT 1";
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':email',$this->email,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':fullname',$this->fullname,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':storename',$this->storename,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){return true;}else{return false;}
    }
    
    public function update_seller_contact_data(){
        $this->dbsql = "UPDATE {$this->table2} SET sc_address = :address,sc_phnumber1 = :phnumber1,sc_phnumber2 = :phnumber2
        WHERE s_id = :id LIMIT 1";
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':address',$this->address,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':phnumber1',$this->phnumber1,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':phnumber2',$this->phnumber2,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){return true;}else{return false;}
    }
    
    public function update_seller_bank_details(){
        $this->dbsql = "UPDATE {$this->table3} SET sa_name = :account_name,sa_number = :account_number,sa_bank = :bank_name
        WHERE s_id = :id LIMIT 1";
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':account_name',$this->account_name,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':account_number',$this->account_number,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':bank_name',$this->bank_name,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){return true;}else{return false;}
    }//end update seller bank details
    
    public function change_password($type='seller'){
        if($type === 'email'){
            $this->dbsql = "UPDATE {$this->table} SET s_password = :password WHERE s_email = :email LIMIT 1";
        }else{
            $this->dbsql = "UPDATE {$this->table} SET s_password = :password WHERE s_id = :id LIMIT 1";
        }
		$this->dbstmt =  $this->dbconn->prepare($this->dbsql);
		$this->dbstmt->bindParam(':password',$this->new_password,PDO::PARAM_STR);
        if($type === 'email'){
            $this->dbstmt->bindParam(':email',$this->email,PDO::PARAM_STR);
        }else{
            $this->dbstmt->bindParam(':id',$this->current_seller,PDO::PARAM_INT);
        }
		
		$this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){return true;}else{return false;} 
    }//end of change password
    
    public function change_status($type='seller'){
        if($type === 'seller'){// update seller status
            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            try{
                //begin transaction
                $this->dbconn->beginTransaction();
                //change status
                $this->dbsql = "UPDATE {$this->table} SET s_status = :status WHERE s_id = :id LIMIT 1";
                $this->dbstmt = $this->dbconn->prepare($this->dbsql);
                $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
                $this->dbstmt->bindParam(':status',$this->status,PDO::PARAM_STR);
                $this->dbstmt->execute();
                if($this->status === 'suspended'){
                    $this->p_status = 'unavailable';
                    //set active product of this seller to unavailable
                    $this->dbsql = "UPDATE {$this->product_table} SET p_status = :status WHERE p_status = 'available' AND s_id = :id";
                    $this->dbstmt = $this->dbconn->prepare($this->dbsql);
                    $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
                    $this->dbstmt->bindParam(':status',$this->p_status,PDO::PARAM_STR);
                    $this->dbstmt->execute();
                }
                if($this->dbconn->commit()){return true;}//if commit
            }catch(PDOException $e){
                //rollback
                if($this->dbconn->rollback()){return false;}//if rollback
            }// end of try and catch
        }elseif($type === 'seller_type'){//update seller type
            $this->dbsql = "UPDATE {$this->table} SET s_type = :type WHERE s_id = :id LIMIT 1";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':type',$this->status,PDO::PARAM_STR);
            $this->dbstmt->execute();
            $this->dbnumRow = $this->dbstmt->rowCount();
            if($this->dbnumRow > 0){return true;}else{return false;}
        }elseif($type === 'seller_request'){//update seller request mode
            $this->dbsql = "UPDATE {$this->table4} SET sr_mode = :mode WHERE sr_id = :sr_id LIMIT 1";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':sr_id',$this->id,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':mode',$this->status,PDO::PARAM_STR);
            $this->dbstmt->execute();
            $this->dbnumRow = $this->dbstmt->rowCount();
            if($this->dbnumRow > 0){return true;}else{return false;}
        }
        
    }
    
    public function delete_seller(){ // will also delete seller product
        $this->dbconn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        try{
            //begin transaction
            $this->dbconn->beginTransaction();
            $this->status = 'deleted';
            $this->mode = 'completed';
            //delete seller
            $this->dbsql = "UPDATE {$this->table} SET s_status = :status WHERE s_id = :id LIMIT 1";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':status',$this->status,PDO::PARAM_STR);
            $this->dbstmt->execute();
            
            //delete product of this seller
            $this->dbsql = "UPDATE {$this->product_table} SET p_status = :status WHERE s_id = :id";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':id',$this->id,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':status',$this->status,PDO::PARAM_STR);
            $this->dbstmt->execute();
            
            if(content_data('seller_request_table','sr_id',$this->id,'s_id',"AND sr_type = 'delete account' AND sr_mode IN ('pending','ongoing')") !== false){
            //update mode
            $this->dbsql = "UPDATE {$this->table4} SET sr_mode = :mode WHERE sr_id = :sr_id LIMIT 1";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':sr_id',$this->sr_id,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':mode',$this->mode,PDO::PARAM_STR);
            $this->dbstmt->execute();
            }
            // commit the transation
            if($this->dbconn->commit()){return true;}//if commit
        }catch(PDOException $e){
            //rollback
            if($this->dbconn->rollback()){return false;}//if rollback
        }// end of try and catch
    }
    
    public function change_image(){
        $this->full_file_name = get_media('seller',$this->current_seller);
        $this->full_path = file_location('media_path',$this->full_file_name);
        if(content_data($this->media_table,'sm_id',$this->current_seller,'s_id') !== false){
            $this->dbsql = "UPDATE {$this->media_table} SET sm_link_name = :link_name,sm_extension = :extension WHERE s_id = :id LIMIT 1";
        }else{
            $this->dbsql = "INSERT INTO {$this->media_table}(sm_link_name,sm_extension,s_id)VALUES(:link_name,:extension,:id)";
        }
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':link_name',$this->file_name,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':extension',$this->extension,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':id',$this->current_seller,PDO::PARAM_INT);
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){
            //delete the current image
            if(file_exists($this->full_path) && $this->full_file_name !== 'home/avatar.png' && is_file($this->full_path)){unlink($this->full_path);}
            return true;
        }else{
            //delete image
            $this->full_file_name = $this->file_name.".".$this->extension;
            $this->full_path = file_location('media_path','seller/'.$this->full_file_name);
            if(file_exists($this->full_path) && $this->full_file_name !== 'home/avatar.png' && is_file($this->full_path)){unlink($this->full_path);}
            return false;
        }
    }//end of store user image
}
?>