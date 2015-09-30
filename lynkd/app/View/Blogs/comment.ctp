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
						<div class="blueHeading">Post comment </div>
						<div class="messageInfo">
							<table id="viewinbox" class="table">
				<tbody>
						<tr>
										<th align="center">S.No</th>
										<th align="center">Comment</th>
										<th align="center">Action</th>
						</tr>
									<?php  if(!empty($comment)){ ?>
									<?php $sno=1;?>
									<?php foreach($comment as $blogcomment) {?>
												<tr>												
													<td align="center"><?php echo $sno; ?> </td> 
													<td align="center"><?php echo ucfirst($blogcomment['Comment']['comment']); ?></td>		
													<td class="center" align="center">
             <form></form>
            <?php 
			//debug($this->params['pass'][0]);
			echo $this->Form->postLink($this->Html->image('../images/icons/admins/delete.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('controller'=>'blogs','action'=>'comment_delete',$blogcomment['Comment']['id'],$this->params['pass'][0]),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Delete'),__('Are you sure you want to delete this comment?'));?>
			
					</td>													
					</tr>	
			<?php $sno++ ?>
		<?php } } else { ?>
				<tr>												
					<td colspan="4" align="center">No comment found</td>
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