<?php
//BRAND FUNCTION STARTS
//function get brand starts
function show_brand($brand,$type='default'){
    if($type === 'default'){
      ?>
      <a href='<?=file_location('home_url','brand/'.$brand.'/')?>'>
       <div class='j-col s6 m4 l2 'style='padding:3px 3px 3px 3px'>
        <div class='j-color7 j-padding j-text-color4 j-clickable j-round-large j-card-4 j-border-2 j-border-color3'>
          <div class='j-padding j-round-large j-border-2 j-border-color4 j-card-4'>
            <center><div class='j-medium'><b><?=strtoupper($brand)?></b></div></center>
          </div>
        </div>
       </div>
      </a>
      <?php
    }
}
//function get brand ends
//BRAND FUNCTION ENDS
?>