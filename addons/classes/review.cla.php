<?php
trait review{
    protected $review_table = 'review_table';
    
    public $r_id;
    public $r_rating;
    public $r_name;
    public $r_title;
    public $r_feedback;
    public $r_regdatetime;
    public $p_id;
    public $s_id;
    
    private $current_user;
    private $last_id;
    
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
    
    public function insert_review(){
        if(content_data('review_table','or_id',$this->id,'or_id') === false ){
            $this->dbsql = "INSERT INTO {$this->review_table}(r_rating,r_name,r_title,r_feedback,or_id,p_id,s_id,u_id)
            VALUES(:rating,:name,:title,:feedback,:or_id,:p_id,:s_id,:id)";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':rating',$this->r_rating,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':name',$this->r_name,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':title',$this->r_title,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':feedback',$this->r_feedback,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':or_id',$this->id,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':p_id',$this->p_id,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':s_id',$this->s_id,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':id',$this->current_user,PDO::PARAM_INT);
            $this->dbstmt->execute();
            $this->dbnumRow = $this->dbstmt->rowCount();
            if($this->dbnumRow > 0){return true;}else{return false;}
        }else{
            return false;
        }
    }//end insert user
}
?>