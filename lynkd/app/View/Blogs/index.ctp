<section class="wrapper">
  <section class="mid-cnt"> 
  	<?php echo $this->Session->flash(); ?>
    <!--  left sidebar start -->
    <?php  echo $this->Element('accountsidebar');?>
    <!--  left sidebar end -->
    
   <section class="mid-right"> 
				<div style="display: none;" class="overlayIcon"></div>
				<div id="inbox" style="display: block;">
					<div class="rightCol">
					
				
						<div class="blueHeading">Manage Post </div>
						<div class="messageInfo">
						
							<table id="viewinbox" class="table">
				<tbody>
						<tr>
										<th align="center">S.No</th>
										<th align="center">Title</th>
										<th align="center">Created</th>
										 <th align="center">Action</th>
									</tr>
									
									
									<?php  if(!empty($users)){ ?>
									<?php $sno=1;?>
									<?php foreach($users as $blog) {?>
												<tr>												
													<td align="center"><?php echo $sno; ?> </td> 
													<td align="center"><?php echo ucfirst($blog['Blog']['title']); ?></td>		
													<td align="center"><?php echo date("d-m-y H:i:s",strtotime($blog['Blog']['created'])); ?></td>
													<td class="center" align="center">
             <form></form>
            <?php echo $this->Html->link($this->Html->image('../images/icons/admins/comment.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('action' => 'comment', $blog['Blog']['id']),array('class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'comment','escape'=>false)); ?>
			
			<?php echo $this->Html->link($this->Html->image('../images/icons/admins/edit.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('action' => 'edit', $blog['Blog']['id']),array('class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Edit','escape'=>false)); ?>
			
            <?php echo $this->Form->postLink($this->Html->image('../images/icons/admins/delete.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('controller'=>'blogs','action'=>'delete',$blog['Blog']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Delete'),__('Are you sure you want to delete #%s?', $blog['Blog']['title']));?>
            <?php //echo $this->Form->postLink($this->Html->image('../images/icons/admins/options.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('controller'=>'Blogoptions','action'=>'index',$user['Blog']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Manage options'));?>    
			
           <?php if ($blog['Blog']['status']=='0'){?>
			<?php echo $this->Form->postLink($this->Html->image('../images/icons/admins/deactivate.png',array('border'=>'0','class'=>'iconb','width'=>'17')), array('action' => 'activate', $blog['Blog']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Active'),__('Are you sure you want to activate #%s?', $blog['Blog']['title']));?><?php }else { ?>
			<?php echo $this->Form->postLink($this->Html->image('../images/icons/admins/activate.png',array('border'=>'0','class'=>'iconb','width'=>'17')), array('action' => 'block', $blog['Blog']['id']), array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Block'),__('Are you sure you want to block #%s?', $blog['Blog']['title'])); ?><?php }?>
			
			<?php echo $this->Html->link($this->Html->image('../images/icons/admins/repost.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('action' => 'repost', $blog['Blog']['id']),array('class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Repost','escape'=>false)); ?>
			 
			
					
					</td>													
					</tr>	
			<?php $sno++ ?>
		<?php } } else { ?>
				<tr>												
					<td colspan="4" align="center">No record found</td>
				</tr>											
		<?php } ?>								
	</tbody>
	</table> 
																					
	<div class="pagination">
	<?php  if($this->Paginator->hasPrev()){
	echo $this->Paginator->prev('&laquo;', array( 'tag' => 'false', 'escape' => false), null, array('class' => 'prev disabled prv' ,'tag' => 'false', 'escape' => false));
	}
    echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'false' ,'currentClass' => 'active', 'currentTag' => 'a' , 'escape' => false));
	if($this->Paginator->hasNext()){
    echo $this->Paginator->next('&raquo;', array( 'tag' => 'false', 'escape' => false), null, array('class' => 'next disabled nxt' ,'tag' => 'false', 'escape' => false)); 
	}
	?>
 </div>					
				
			</div>
			</div>
			</div>
			   
                
				
				
            </section>
				<?php echo $this->Element('friend_section'); ?>
  </section>
</section>