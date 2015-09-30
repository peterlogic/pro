<section class="wrapper">
  <section class="mid-cnt"> 
    <!--  left sidebar start -->
    <?php  echo $this->Element('left_sidebar'); ?>
    <!--  left sidebar end -->
    
    <section class="mid-right mob-marginTB0">
      <section class="login-outer"> 
      <div class="loginInner">
    <div class="borderCol">
      <h1>Login</h1>
      <div class="smallHead">Don't have an account? <?php echo $this->Html->link('Sign up',array('controller'=>'users','action'=>'register')); ?> Its easy !</div>
      </div>
      <div class="clear"></div>
	  
	 
   <div class="accountInfo">
      <div class="smallHead">Login using registered account</div>
	<?php echo $this->Session->flash();?>
	  <?php echo $this->Form->create('User',array('method'=>'Post', 'id'=>'loginform')); ?>
		<div class="input-outer">
        <span class="user-icon"></span>
        <input type="text" class="login-input"  name="data[User][username]"  placeholder="Username"  />
        </div>
        
        <div class="input-outer">
        <span class="lock-icon"></span>
        <input type="password"  name="data[User][password]" class="login-input"   placeholder="password" />
        </div>
       <?php echo $this->Html->link('Forgot your password?',array('controller'=>'users','action'=>'forgot'),array('class'=>'forgot')); ?>
      
        <input type="submit" name="submit" class="submitBtn" value="Login" />
		
<?php echo $this->Form->end(); ?>
      
      </div> 
      
      </div>
      </section>
    </section>
  </section>
</section>