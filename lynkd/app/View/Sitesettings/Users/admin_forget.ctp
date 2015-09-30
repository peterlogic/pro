<style>
.flashMessage{width: 234px;}
body{background:none repeat scroll 0 0 #1c1c1c;}
#top{background:none;}
.logControl input[type="submit"] {float: left;font-size: 16px; padding: 8px 0; width: 100%;}
.logControl {margin-top: 0 !important;}
.loginWrapper input[type="text"], .loginWrapper input[type="password"] {margin-top: 0 !important;}
.forget-password {float: left;font-size: 11px;padding: 3px 0;text-align: left;}
.loginWrapper {margin: -166px 0 0 -120px !important;}
</style>
<script type="text/javascript">
		$(document).ready(function(){
			$('#flash').live('click',function(){
				$('#flash').fadeOut(3000);
				});
		});        
</script>
<div class="loginWrapper">

	<!-- Current user form -->
   <?php echo $this->Form->create('User',array('method'=>'post','id'=>'validate')); ?>
     <div class="loginPic" >
        <span><?php echo $this->Html->image('top-logo.png',array('width'=>'100')); ?></span>
		<span style="color:#fff;">Forgot Password</span>
         
        </div>
			<?php echo $this->Form->input('email',array('label'=>"",'placeholder'=>'Email','class'=>'loginEmail','type'=>'email','required')); ?>
			
			<?php  $x=$this->Session->flash(); if($x){?>
				<div class="err_msg"><?php echo $x; ?></div>
			<?php } ?>
        <div class="logControl"> 
			<?php echo $this->Form->submit('Submit',array('name'=>'submit','value'=>'Submit','class'=>'buttonM bBlue')); ?>
        <div>
			<a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'admin_login')); ?>" class="forget-password" style="text-decoration: none;" >Back to Login</a>
        </div>
        </div>       
    </form>   
</div>
<script type="text/javascript">
   $(document).ready(function(){
       $('#validate').validate();
   });
</script>