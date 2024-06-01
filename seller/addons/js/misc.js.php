<?php //MISC JS STARTS ?>
<?php if(php_self('/product/preview_product.enc.php','seller')){ ?>
<?php //change status?>
function cs(t,i,s){loading('Updating','id','upbtn'+t);let d="/"+t+"/"+i+"/"+s+"/";
$.ajax({type:'GET',url:sdar+'act/cs'+d,cache:false,dataType:'JSON'}).fail(function(e,f,g){r_b('Update','id','upbtn'+t);$('#st').html(r_m2('Sorry!!!<br>Error occurred while changing status'));})
.done(function(s){$('#st').html(r_m2(s.message));if(s.status==='success'){window.location='';}else{r_b('Update','id','upbtn'+t);}})
alertoff();
}
<?php } ?>
<?php if(php_self('/product/preview_product.enc.php','seller')){ ?>
<?php //delete content ?>
function dc(t,i){loading('Deleting','class','dcbtn'+t);let d="/"+t+"/"+i+"/";
$.ajax({type:'GET',url:sdar+'act/dc'+d,cache:false,dataType:'JSON'}).fail(function(e,f,g){r_b('Delete','class','dcbtn'+t);$('#st').html(r_m2('Sorry!!!<br>Error occurred while deleting '+t));})
.done(function(s){$('#st').html(r_m2(s.message));if(s.status==='success'){window.location='';}else{r_b('Delete','class','dcbtn'+t)}})
alertoff();
}
<?php } ?>
<?php if(php_self('/product/insert_product.enc.php','seller') || php_self('/product/update_product.enc.php','seller')
         || php_self('/account/index.php','seller')){ ?>
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
  $.ajax({type:'POST',url:sdar+'act/ci',data:d,cache:false,contentType:false,processData:false,dataType:'JSON'})
  .fail(function(e){$('#st').html(r_m2('Sorry!!!<br>Error occurred while uploading image'));})
  .done(function(s){$('#st').html(r_m2(s.message));if(s.status==='success'){window.location='';}})
 }else{
  $('#st').html(r_m('No file selected'));
 }
 alertoff();
}
<?php //remove image ?>
function ri(t,i){loading('Removing','class','rmbtn')
 $.ajax({url:sdar+"act/ri/"+t+'/'+i+'/',cache:false,dataType:'JSON'})
 .fail(function(e){$('#st').html(r_m2('Sorry!!!<br>Error occurred while removing photo'));r_b('Remove','class','rmbtn');})
 .done(function(s){$('#st').html(r_m2(s.message));if(s.status==='success'){window.location='';}else{r_b('Remove','class','rmbtn');}});alertoff();}
<?php } ?>