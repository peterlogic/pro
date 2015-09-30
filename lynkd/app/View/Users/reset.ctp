<section class="wrapper">
  <section class="mid-cnt"> 
    <!--  left sidebar start -->
    <?php  echo $this->Element('left_sidebar'); ?>
	<?php echo $this->Html->script(array('jqueryValidate.js')); ?>
    <!--  left sidebar end -->
    
    <section class="mid-right mob-marginTB0">
      <section class="login-outer"> 
      <div class="loginInner">
    <div class="borderCol">
      <h1>Reset Password</h1>
      <div class="smallHead">Don't have an account? <?php echo $this->Html->link('Sign up',array('controller'=>'users','action'=>'register')); ?> Its easy !</div>
      </div>
      <div class="clear"></div>
	  
	 
   <div class="accountInfo">	
		    <?php echo $this->Session->flash();?>
	  <?php echo $this->Form->create('User',array('method'=>'Post', 'id'=>'validate')); ?>
		<div class="input-outer">
        <span class="user-icon"></span>
        <input type="password" class="login-input"  name="password"  placeholder="Enter new password"  id='password' />
        </div>
		<div class="input-outer">
        <span class="user-icon"></span>
        <input type="password" class="login-input"  name="confirm_password" placeholder="Enter confirm password"  />
        </div>
      <?php echo $this->Html->link('Back to login',array('controller'=>'users','action'=>'login'),array('class'=>'forgot')); ?>
	
    
        <input type="submit" name="submit" class="submitBtn" value="Reset Password" />
		
<?php echo $this->Form->end(); ?>
      
      </div> 
      
      </div>
      </section>
    </section>
  </section>
</section>
<script>
$(document).ready(function(){
$("#validate").validate({

	
	  rules:
	   {
													
			"password":{
												required:true,
												 minlength: 5
									 },	

				"confirm_password":{
													required: true,
													minlength: 5,
													equalTo: "#password"
									 }				
            },
			
			
  messages:

	    {
			
			"password": {
											required: "This field is required",
											minlength: "password contain atleast 5 character"
											
									},

														
				"confirm_password": {
											   required: "This field is required",
											   minlength: "password contain atleast 5 character",
											   equalTo: "Passwords do not match"
											
									}
			
	    }			
							
});    	

});
</script>