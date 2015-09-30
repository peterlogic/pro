<div class="glb-cont">
<script type="text/javascript">
		$(document).ready(function(){
			$('#flash').live('click',function(){
				$('#flash').fadeOut(3000);
				});
		});        
</script>
        
<!-- Login wrapper begins -->
<div class="loginWrapper">

	<!-- Current user form -->
   <?php echo $this->Form->create('User',array('method'=>'post','id'=>'validate')); ?>
        <div class="loginPic">
           
		   <span><?php echo $this->Html->image('logo.png',array('border'=>'0')); ?></span>
      
         <?php $x=$this->Session->flash(); if($x){ ?>
          <div class="nNote nSuccess" id="flash">
              <div class="alert alert-success" style="text-align:center;color:red;" ><?php echo $x; ?></div>
          </div><?php } ?>
            
        </div>
		<div class="login-form">
		<div class="login-header">
		<span>Reset Password</span>
		</div>
		
        <?php echo $this->Form->input('password',array('label'=>"",'placeholder'=>'Password','class'=>'loginEmail','type'=>'password','required')); ?>
        <?php echo $this->Form->password('cpassword',array('label'=>"",'placeholder'=>'Confirm Password','class'=>'loginPassword','type'=>'password','required')); ?>
 
      
        <div class="logControl">
        <div class="left">
        <input type="submit" name="submit" value="Save" class="login-btn" /></div>
        <div class="forgot">   
				
              <a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'admin_login')); ?>">Cancel</a>
        </div>
        </div>
		</div>
		<!--- login-form----->
    </form>

</div>
</div>