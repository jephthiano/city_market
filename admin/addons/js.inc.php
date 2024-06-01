<script>
<?php
$js = ['general','admin','seller','social_handle','message','category','product','user','order','transaction','misc','log','refund','return'];
foreach($js AS $section){require_once(file_location('admin_inc_path',"js/$section.js.php"));}
?>
</script>