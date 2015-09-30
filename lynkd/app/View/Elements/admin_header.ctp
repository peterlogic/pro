<div id="top">
    <div class="wrapper">
		
        <a href="<?php echo Router::url(array('controller'=>'users','action'=>'admin_dashboard'),true); ?>" title="Crowd Career" class="logo">
		<span><?php echo $this->Html->image('top-logo.png',array('style'=>'width:45px;')); ?></span>
       
     <span style="font-size:20px;color:white;float:left;margin:6px 0px 0px 9px;"><b></b></span>
     </a>
        <script type="text/javascript">
		$(document).ready(function(){
			$('#flash').live('click',function(){
				$('#flash').fadeOut(3000);
				});
		});        
        </script>
        <script type="text/javascript">
$(function(){
$(".tool-tip").tipTip({defaultPosition:'tip_right_bottom'});
});
</script>