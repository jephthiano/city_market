<?php
// connection function
function dbconnect($userType, $connectionType){
	if($userType === "admin"){// ALL GRANT PRIVILEDGES for admin connection only
		if(strstr(file_location('home_url',''),'000webhostapp')){
			#FOR 000WEBHOST
			$username = 'id20275507_all_act';
			$password = 'cQHWReW_3LEW2T]&';
			$db = 'id20275507_mystoredb';
			$server = 'live';
		}else{
			#FOR LOCAL HOST
			$username = 'root';
			$password = 'jobservicesJEHOVAHgod333';
			$db = 'citymarket_db';
		}
		//CREATE DATABASE
		@$pre_conn = new mysqli('localhost',$username,$password);
		$sql = "CREATE DATABASE IF NOT EXISTS {$db}";
		@$pre_conn->query($sql);
		
		// DEFINING CONNECTION TYPE
		if($connectionType === 'PDO'){ // for pdo
			try{
				return new PDO ("mysql:host=localhost; dbname=$db; charset=utf8", $username, $password);
				// set the PDO error mode to excepption
				$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				echo 'connected successfully';
			}catch(PDOException $e){
				echo 'connection failed:'. $e->getMessage();
			}
		}	
	}else{// run this if no connection is specified
		exit('Error occurred while connecting to site');
	}
}
?>