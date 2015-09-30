<aside class="mid-left">
    <section class="leftCol">
      <div class="profileThumbCol">
	  	
      <ul id="usual1" class="leftListing">
      
      <!--  <li class=""><a href="#send" class="">Manage Blog</a></li> -->

		 <li ><?php echo $this->Html->link('Video Upload Section','javascript:void(0);',array('class'=>'selected')); ?></li>
		 <?php if($this->Session->check('Auth.User.id')) { ?>
		 <li ><?php echo $this->Html->link('Back to Profile Page',array('controller'=>'Users','action'=>'profile')); ?></li>
		 <?php } ?>
	
      </ul>
    </div></section>
  </aside>