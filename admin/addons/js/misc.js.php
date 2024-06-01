<?php //MISC JS STARTS ?>
<?php if(php_self('/misc/run_action.enc.php','admin')){ ?>
<?php //run action ?>
function ra(){loading('Running Action','id','rabtn');
$.ajax({type:'GET',url:adar+'act/ra/',cache:false,dataType:'JSON'}).fail(function(e,f,g){r_b('Run Actions','id','rabtn');$('#st').html(r_m2('Sorry!!!<br>Error occurred while running action'));})
.done(function(s){$('#st').html(r_m2(s.message));if(s.status==='success'){window.location='';}else{r_b('Run Actions','id','abtn');}})
alertoff();
}
<?php } ?>
<?php if(php_self('/misc/settings.enc.php','admin')){ ?>
<?php //change site settings ?>
function css(s,k,v){
 if(v.length > 0){loading('Saving','class',k);
  $.ajax({type:'POST',url:adar+'act/css/',data:{"s":s,"k":k,"v":v},cache:false,dataType:'JSON'}).fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while saving setting, try again'));r_b('Save','class',k);})
  .done(function(s){$('#st').html(r_m2(s.message));if(s.status==='success'){window.location='';}else{r_b('Save','class',k);}})
 }else{
  $('#st').html(r_m2('Sorry!!!<br>Field cannot be empty, add some text and try again'));
 }
}
<?php } ?>
<?php if(php_self('/admin/preview_admin.enc.php','admin') || php_self('/user/preview_user.enc.php','admin')
         || php_self('/product/preview_product.enc.php','admin') || php_self('/product/index.php','admin')
         || php_self('/order/preview_order.enc.php','admin') || php_self('/seller/preview_seller.enc.php','admin')
         || php_self('/request/preview_request.enc.php','admin')){ ?>
<?php //change status?>
function cs(t,i,s){loading('Updating','id','upbtn'+t);let d="/"+t+"/"+i+"/"+s+"/";
$.ajax({type:'GET',url:adar+'act/cs'+d,cache:false,dataType:'JSON'}).fail(function(e,f,g){r_b('Update','id','upbtn'+t);$('#st').html(r_m2('Sorry!!!<br>Error occurred while changing status'));})
.done(function(s){$('#st').html(r_m2(s.message));if(s.status==='success'){window.location='';}else{r_b('Update','id','upbtn'+t);}})
alertoff();
}
<?php } ?>
<?php if(php_self('/admin/preview_admin.enc.php','admin') || php_self('/admin/index.php','admin')
      || php_self('/social_handle/preview_social_handle.enc.php','admin') || php_self('/social_handle/index.php','admin')
      || php_self('/message/preview_message.enc.php','admin') ||  php_self('/message/index.php','admin')
      || php_self('/category/preview_category.enc.php','admin') ||  php_self('/category/index.php','admin')
      || php_self('/category/preview_subcategory.enc.php','admin') ||  php_self('/category/subcategory.enc.php','admin')
      || php_self('/product/preview_product.enc.php','admin') ||  php_self('/product/index.php','admin')
      || php_self('/user/preview_user.enc.php','admin') || php_self('/request/preview_request.enc.php','admin')
      || php_self('/product/preview_product.enc.php','admin') || php_self('/seller/preview_seller.enc.php','admin')){ ?>
<?php //delete content ?>
function dc(t,i){loading('Deleting','class','dcbtn'+t);let d="/"+t+"/"+i+"/";
$.ajax({type:'GET',url:adar+'act/dc'+d,cache:false,dataType:'JSON'}).fail(function(e,f,g){r_b('Delete','class','dcbtn'+t);$('#st').html(r_m2('Sorry!!!<br>Error occurred while deleting '+t));})
.done(function(s){$('#st').html(r_m2(s.message));if(s.status==='success'){window.location='';}else{r_b('Delete','class','dcbtn'+t)}})
alertoff();
}
<?php } ?>
<?php if(php_self('/admin/edit_profile.enc.php','admin') || php_self('/admin/insert_admin.enc.php','admin')
         || php_self('/category/insert_category.enc.php','admin') || php_self('/category/update_category.enc.php','admin')
         || php_self('/category/insert_subcategory.enc.php','admin') || php_self('/category/update_subcategory.enc.php','admin')
         || php_self('/product/insert_product.enc.php','admin') || php_self('/product/update_product.enc.php','admin')){ ?>
<?php // trigger file upload input ?>
function ti(t){t.trigger('click');}
<?php // process image?>
function pi(o,f,t='single'){
 var fil = document.getElementById('image');
 if(t ==='multi'){
  const file = o.files;
  if(file.length > 0){
   f.style.display='block';f.innerHTML = '';
   if(file.length < 5){
    for(var i = 0; i < 4; i++){
     const reader = new FileReader(); reader.readAsDataURL(file[i]);
     if(cuft(file[i]) === 'image'){
      reader.addEventListener('load',function(){
       var child = "<img src='"+this.result+"'class='j-border-color7 j-border-2 j-round'style='width:100px;;height:100px;margin-left:8px;'>";f.innerHTML += child;
      });
     }else{
      fil.value='';f.style.display='none';f.innerHTML = '';
      $('#st').html(r_m2('Sorry!!!<br>Only image is allowed, please re-select.'));
     }
    }
   }else{
    fil.value='';f.style.display='none';f.innerHTML = '';
    $('#st').html(r_m2('Sorry!!!<br>Only 4 images are allowed at maximum, please re-select.'));
   }
  }else{f.style.display='none';f.innerHTML = '';}
 }else{
  const file = o.files[0];
  if(file){
   const reader = new FileReader(); reader.readAsDataURL(file);
   if(cuft(file) === 'image'){
    reader.addEventListener('load',function(){
     var child = "<img src='"+this.result+"'class='j-round'style='height:inherit;width:inherit;opacity:0.8'><span class='j-text-color4 j-bold j-vertical-center-element'style='font-size:40px;'>+</span>";
     f.innerHTML = child;
    });
   }else{
    fil.value='';
    var child = "<span class='j-text-color4 j-bold j-vertical-center-element'style='font-size:40px;'>+</span>";f.innerHTML=child;
    $('#st').html(r_m2('Sorry!!!<br>Only image is allowed, please re-select.'));
   }
  }else{
    var child = "<span class='j-text-color4 j-bold j-vertical-center-element'style='font-size:40px;'>+</span>";f.innerHTML=child;
  }
 }
}
<?php //check upload file type?>
function cuft(f){
 if(f.type.match('image.*')){
  return 'image';
 }else if(f.type.match('video.*')){
  return 'video';
 }else if(f.type.match('audio.*')){
  return 'audio';
 }else{
  return 'other';
 }
}
<?php //change image?>
function ci(i,t,c,z){let f = i.files[0];
 if(f){
  let n = i.getAttribute('name');let d = new FormData();d.append(n,f),d.append('t',t),d.append('i',c),d.append('s',z);
  $.ajax({type:'POST',url:adar+'act/ci',data:d,cache:false,contentType:false,processData:false,dataType:'JSON'})
  .fail(function(e){$('#st').html(r_m2('Sorry!!!<br>Error occurred while uploading image'));})
  .done(function(s){$('#st').html(r_m2(s.message));if(s.status==='success'){window.location='';}})
 }else{
  $('#st').html(r_m('No file selected'));
 }
 alertoff();
}
<?php //remove image ?>
function ri(t,i){loading('Removing','class','rmbtn')
 $.ajax({url:adar+"act/ri/"+t+'/'+i+'/',cache:false,dataType:'JSON'})
 .fail(function(e){$('#st').html(r_m2('Sorry!!!<br>Error occurred while removing photo'));r_b('Remove','class','rmbtn');})
 .done(function(s){$('#st').html(r_m2(s.message));if(s.status==='success'){window.location='';}else{r_b('Remove','class','rmbtn');}});alertoff();}
<?php } ?>