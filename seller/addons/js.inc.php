<script>
<?php
$js = ['general','seller','product','category','misc'];
foreach($js AS $section){require_once(file_location('seller_inc_path',"js/$section.js.php"));}
?>
</script>