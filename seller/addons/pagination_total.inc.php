<?php
// creating connection
require_once(file_location('inc_path','connection.inc.php'));
@$conn = dbconnect('admin','PDO');
if(empty($searchtext)){// if the search text is not empty
  //PAGINATION CODE START HERE
  $display = 20; // number of records to show per page
  //calculate the number of pages
  if(php_self('/ajax/get/get_product_result.xhr.php','admin')){ //for product
    $total_records = get_numrow('product_table','p_status',$status2,"return",'no round',"AND s_id = {$slid}");
  }
  
  if($total_records > $display){ // if the number of record is more than the displayed num(10)
    $total_pages = ceil($total_records / $display);
  }else{ // if the number of record is not more than the displayed num(10)
    $total_pages = 1;
  }
  
  // getting the current page and where to start
  if(isset($cur_page) && is_numeric($cur_page) && $cur_page > 0){ // for other pages other than first page
    $current_page =  $cur_page; //  get the current page from the url if it is  not the first page
    $start = ($current_page * $display) - $display;            // use the current page to determine the $start in the LIMIT
    if($cur_page > $total_pages){die(page_not_available(''));}// what to echo if the user enter more than maximum page
  }else{ // if $_GET IS empty
    $current_page = 1;  $start = 0;// for the first page
  }
}
?>