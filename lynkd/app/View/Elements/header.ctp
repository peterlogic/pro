
<ul>
          <li><?php echo $this->Html->link('Home',array('controller'=>'/')); ?></li>
         <!-- <li><?php //echo $this->Html->link('Blogs','javascript:void(0);'); ?></li> -->
		 <?php if($this->Session->check('Auth.User')) 
		 { ?>
          <li><?php echo $this->Html->link('Post',array('controller'=>'Blogs','action'=>'index')); ?></li>
		  <?php }?>
          <li><?php echo $this->Html->link('Contact us',array('controller'=>'users','action'=>'contact')); ?></li>
		  
			<?php if(!$this->Session->check('Auth.User')) 
			{ ?>
				  <li class="login"><?php echo $this->Html->link('Login',array('controller'=>'users','action'=>'login'),array('class'=>'login')); ?></li>
				  <li class="register"><?php echo $this->Html->link('Register',array('controller'=>'users','action'=>'register'),array('class'=>'signup')); ?></li>
			<?php } ?> 
</ul>