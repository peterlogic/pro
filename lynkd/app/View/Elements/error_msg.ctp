<div class="error_msg" id="error_msg"><b><?php echo $message; ?></b>
<?php if(isset($errors) && !empty($errors)){ 
	echo '<br />';
	foreach($errors as $error){
		echo '<br />'.$error[0];
	}
 } ?></div>
<script>
$('#error_msg').live('click',function(){
	$('#error_msg').fadeOut(3000);
	});
 
</script>