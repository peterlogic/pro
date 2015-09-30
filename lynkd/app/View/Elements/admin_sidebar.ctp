<script src="http://maxcdn.bootstrapcdn.com/bootstrap/2.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://bootstrapdocs.com/v2.3.2/docs/assets/js/bootstrap-collapse.js"></script>	
<?php echo $this->Html->script(array('scroll')); ?>
<!-- Sidebar begins -->
<div id="sidebar">
    <div class="mainNav" id="scrollbox3">
              
        <!-- Main nav -->
        <ul class="nav accordion" id="accordion2">
           <li class="nav-icon accordion-group">
		   <div class="accordion-heading">
				   <a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'admin_dashboard')); ?>" class="<?php echo (($this->params['controller'] == 'users' && $this->params['action'] == 'admin_dashboard')?'collapsed':'' ); ?>" >
							<span class="icon icon-dashboard"></span>
								<span>Dashboard</span>
				   </a>
			   </div>
		   </li>
		   
		  
		 <li class="nav-icon accordion-group">
		   <div class="accordion-heading">
			   <a data-toggle="collapse" data-parent="#accordion61" href="#collapsesix1" class="<?php echo (($this->params['controller'] == 'users' && $this->params['action'] != 'admin_dashboard')?'collapsed':''); ?>">
						<span class="icon icon-profile"></span>
							<span>Users</span>
			   </a>
            </div>
			<div id="collapsesix1" class="<?php echo (($this->params['controller'] == 'users' && $this->params['action'] != 'admin_dashboard')?'accordion-body in collapse':'accordion-body collapse'); ?>">
			
			  <div class="accordion-inner">
				<a class="<?php echo (($this->params['controller'] == 'users' && $this->params['action']=='admin_add')?'active':''); ?>" href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'add')) ?>" title="">
							<span>Add New User</span>
		      </a>
			  </div>
			  <div class="accordion-inner">
				<a class="<?php echo (($this->params['controller'] == 'users' && $this->params['action']=='admin_index')?'active':''); ?>" href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'index')) ?>" title="">
							<span>Manage User</span>
		      </a>
			  </div>			  
			</div>
		   </li> 
        <li class="nav-icon accordion-group">
		   <div class="accordion-heading">
		   <a data-toggle="collapse" data-parent="#accordion2" href="#collapsetwo" class="<?php echo (($this->params['controller'] == 'categories')?'collapsed':''); ?>" >
					<span class="icon icon-calendar"></span>
						<span>Category</span>
		   </a>
            </div>
			<div id="collapsetwo" class="<?php echo (($this->params['controller'] == 'categories')?'accordion-body in collapse':'accordion-body collapse'); ?>">
			  <div class="accordion-inner">
				<a class="<?php echo (($this->params['controller'] == 'categories' && $this->params['action']=='admin_add')?'active':''); ?>" href="<?php echo $this->Html->url(array('controller'=>'categories','action'=>'add')) ?>" title="">
							<span>Add Category</span>
		      </a>
			  </div>
			  <div class="accordion-inner">
				<a class="<?php echo (($this->params['controller'] == 'categories' && $this->params['action']=='admin_index')?'active':''); ?>" href="<?php echo $this->Html->url(array('controller'=>'categories','action'=>'index')) ?>" title="">
							<span>Manage Category</span>
		      </a>
			  </div>			  	
			</div>		
		   </li>    

            <li class="nav-icon accordion-group">
		         <div class="accordion-heading">
					   <a data-toggle="collapse" data-parent="#accordion3" href="#collapsethree" class="<?php echo (($this->params['controller'] == 'blogs')?'collapsed':''); ?>" >
								<span class="icon icon-calendar"></span>
									<span>Blog</span>
					   </a>
						</div>
						<div id="collapsethree" class="<?php echo (($this->params['controller'] == 'blogs')?'accordion-body in collapse':'accordion-body collapse'); ?>">
						
						  <div class="accordion-inner">
							<a class="<?php echo (($this->params['controller'] == 'blogs' && $this->params['action']=='admin_add')?'active':''); ?>" href="<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'add')) ?>" title="">
										<span>Add New Blog</span>
						  </a>
						  </div>
						  <div class="accordion-inner">
							<a class="<?php echo (($this->params['controller'] == 'blogs' && $this->params['action']=='admin_index')?'active':''); ?>" href="<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'index')) ?>" title="">
										<span>Manage Blog</span>
						  </a>
						  </div>			  	
					</div>		
		   </li> 
		   
		   
		    <li class="nav-icon accordion-group">
		   <div class="accordion-heading">
		   <a data-toggle="collapse" data-parent="#accordion2" href="#collapsecms" class="<?php echo (($this->params['controller'] == 'Staticpages')?'collapsed':''); ?>" >
					<span class="icon icon-calendar"></span>
						<span>CMS</span>
		   </a>
            </div>
			<div id="collapsecms" class="<?php echo (($this->params['controller'] == 'Staticpages')?'accordion-body in collapse':'accordion-body collapse'); ?>">
			
			 <!-- <div class="accordion-inner">
				<a class="<?php echo (($this->params['controller'] == 'Staticpages' && $this->params['action']=='admin_add')?'active':''); ?>" href="<?php echo $this->Html->url(array('controller'=>'Staticpages','action'=>'add')) ?>" title="">
							<span>Add cms page</span>
		      </a>
			  </div> -->
			  <div class="accordion-inner">
				<a class="<?php echo (($this->params['controller'] == 'Staticpages' && $this->params['action']=='admin_index')?'active':''); ?>" href="<?php echo $this->Html->url(array('controller'=>'Staticpages','action'=>'index')) ?>" title="">
							<span>Manage cms page</span>
		      </a>
			  </div>			  	
			</div>		
		   </li>    
		   
		   
		   
		      
		    <li class="nav-icon accordion-group">
		   <div class="accordion-heading">
		  <a class="<?php echo (($this->params['controller'] == 'Users' && $this->params['action']=='admin_contactus')?'active':''); ?>" href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'contactus')) ?>" title="">
								<span class="icon icon-calendar"></span>
							<span>Contact us</span>
		      </a>
            </div>
			</li>
		   
		   
		 
	
	
	
	
	
	







   		   
		 
			
        </ul>
    </div>
	</div>
		<script type="text/javascript">
$(function(){
$('#scrollbox3').enscroll({
    showOnHover: true,
    verticalTrackClass: 'track3',
    verticalHandleClass: 'handle3'
});
});
</script>