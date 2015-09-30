<aside class="mid-left">
    <section class="leftCol">
      <div class="profileThumbCol">
	  	
      <ul id="usual1" class="leftListing">
      
      <!--  <li class=""><a href="#send" class="">Manage Blog</a></li> -->
<?php if($this->params['controller'] == 'blogs' &&  $this->params['action'] == 'index'){ $c=  'login selected';} else { $c='login'; } ?>
<?php if($this->params['controller'] == 'blogs' &&  $this->params['action'] == 'add'){ $a=  'login selected';} else { $a='login'; } ?>
		 <li ><?php echo $this->Html->link('Manage Post',array('controller'=>'blogs','action'=>'index'),array('class'=>$c)); ?></li>
		  <li class=""><?php echo $this->Html->link('Add Post',array('controller'=>'blogs','action'=>'add'),array('class'=>$a)); ?></li>
      </ul>
    </div></section>
  </aside>