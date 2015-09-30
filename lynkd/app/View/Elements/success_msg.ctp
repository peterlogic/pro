<div class="success_msg" id="success_msg"><?php echo $message; ?></div>
<script>
$('#success_msg').live('click',function(){
	$('#success_msg').fadeOut(3000);
	});

</script>