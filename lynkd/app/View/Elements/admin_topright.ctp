<div class="topNav">
            <div class="userNav">
            <ul><li>
			<?php //debug($this->Session->read('Auth')); ?>
			<a data-toggle="dropdown" class="dropdown-toggle username" href="#">
				<span class="hidden-xs"><?php echo $this->Session->read('Auth.User.name'); ?></span>
				<?php 
						echo $this->Html->image('default_user_img.png');
						//echo $this->Html->image('/files/profileimage/images55.jpeg');
                     ?>
			</a>
			<ul class="inner-userNav">
			<li>
				<?php echo $this->Html->link('<i class="icon-user"></i>Profile',array('controller'=>'users','action'=>'profile'),array('escape'=>false)); ?></li>
			<li>
				<?php echo $this->Html->link('<i class="icon-cog"></i>Setting',array('controller'=>'sitesettings','action'=>'index'),array('escape'=>false)); ?></li>
			<li>
				<?php echo $this->Html->link('<i class="icon-share"></i>Logout',array('controller'=>'users','action'=>'logout'),array('escape'=>false)); ?></li>
            </ul>
			</li></ul>
            </div>
</div>