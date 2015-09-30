<!--==================== Created the file by T:307 for generating the inbox stytem ========================-->
<!--===== Important jquery attachment  ========-->
<script>
var base_url= "<?php  echo $base_url; ?>";
</script>
<?php echo $this->Html->script('front/jquery-1'); ?>
<?php echo $this->Html->script('front/jquery_003'); ?>
<?php echo $this->Html->script('front/inboxjsfile.js'); ?>
<section class="wrapper">
	<section class="mid-cnt"> 
		<?php  echo $this->Session->flash(); ?>
		<!--  left sidebar start -->
		<aside class="mid-left">
			<section class="leftCol">
			<a onclick="viewWrite()" class="redBtn" href="#deleted">Write</a>
								
				<div id="fade" class="black_overlay"></div>
				<ul id="usual1" class="leftListing">
					<!--li><a onclick="viewWrite()" class="" href="#deleted">Write</a></li-->
					<li><a id="ffcount" class="<?php if($t=='inbox'){ echo 'selected'; } ?>" href="<?php echo $this->Html->url(array('controller'=>'inboxes','action'=>'inbox','inbox')); ?>"  >Inbox (<?php echo count($Unread); ?>)</a></li>
					<li><a class="<?php if($t=='sent'){ echo 'selected'; } ?>" href="<?php echo $this->Html->url(array('controller'=>'inboxes','action'=>'inbox','sent')); ?>">Sent</a></li> 
					<li><a class="<?php if($t=='trash'){ echo 'selected'; } ?>"  href="<?php echo $this->Html->url(array('controller'=>'inboxes','action'=>'inbox','trash')); ?>">Trash</a></li> 
				</ul>
			</section>
		</aside>
		<!--  left sidebar end -->
           
            <section class="mid-right"> 
				<div class="overlayIcon" style="display:none"></div>
				
				<!--====================Show all the inbox message========================-->
				<?php  if($t == 'inbox'){ ?>
				<div style="display: block;" id="aa">
					<div class="rightCol">
						<div class="blueHeading">Inbox</div>
						<div class="messageInfo" id="beforeRequest">
							<table class="table" id="viewinbox">
									<tr>
										<th> S. No.</th>
										<th>From</th>
										<th>Subject</th>
										<th>Time</th>
										 <th>Action</th>
									</tr>
									<?php  
									if(count($inbox)==0){ 
										echo '<tr><td colspan="5">There is no received message to read.</td></tr>';
									}
									else{ 
										if(!empty($inbox)){ $i=1;
											foreach($inbox as $in){  
													if($in['Inbox']['status']=='Unread'){ $class = 'even'; }else{ $class = 'odd'; }
													?><tr class="<?php echo $class;?>">
														<td><?php echo $i; ?></td>
														<td>
															<a onclick="view_inbox(<?php echo $in['Inbox']['id']; ?>)" class="message" role="button" data-toggle="modal" title="View">
																<?php echo $in['Inbox']['from']; ?>
															</a>
														</td>
														<td>
															<a onclick="view_inbox(<?php echo $in['Inbox']['id']; ?>)" class="message" role="button" data-toggle="modal" title="View">
															<?php echo $in['Inbox']['subject']; ?>
															</a>
														</td>
														<td><?php echo $this->Time->timeAgoInWords($in['Inbox']['date']); ?></td>
														<td>
															<?php //echo $this->Form->postLink('Delete<span class="icon-trash" data-icon="&#xe136;"></span>',array('controller'=>'Inboxes','action'=>'trash',$in['Inbox']['id'],'inbox'),array('escape'=>false,'class'=>'','title'=>'Move to Trash'));?>    
														<?php echo $this->Form->postLink('<img alt="delete" width="17" src ="/lynkd/img/../images/icons/admins/delete.png"/>',array('controller'=>'Inboxes','action'=>'trash',$in['Inbox']['id'],'inbox'),array('escape'=>false,'class'=>'','title'=>'Move to Trash'));?>    
														
														</td> 
													</tr><?php 
											$i++; }
										}
										else{
												echo '<tr><td colspan="5">There is no received message to read.</td></tr>';
										}
									}
									?>
							</table>

						</div>
					</div>
				</div>
			   <?php } ?>
			   <!--==================== Show single inbox message ========================-->
                <div style="display: none;" id="showMsg">
					<div class="rightCol">
						<div class="blueHeading">View Message</div>
						<div class="messageInfo"><div id="viewMsg"></div></div>
					</div>
				</div>
				
				<!--==================== Show all the sent message ========================-->
				<?php  if($t == 'sent'){ ?>
				<div style="display: block;" id="aa">
					<div class="rightCol">
						<div class="blueHeading">Sent </div>
						<div class="messageInfo">
							<table id="viewinbox" class="table">
								<tbody>
									<tr>
										<th> S. No.</th>
										<th>To</th>
										<th>Subject</th>
										<th>Time</th>
										 <th>Action</th>
									</tr>	
									<?php  
									$i=1;
									if(count($outbox)==0){ 
										?><tr><td colspan="5">There is no send message to read.</td></tr><?php 
									}
									else{ 
										foreach($outbox as $in){ 
												?><tr>
													<td><?php echo $i; ?></td>
													<td>
														<a onclick="view_outbox(<?php echo $in['Inbox']['id']; ?>)" class="message" role="button" data-toggle="modal" title="View">
															<?php echo $in['Inbox']['to']; ?>
														</a>
													</td>
													<td>
														<a onclick="view_outbox(<?php echo $in['Inbox']['id']; ?>)" class="message" role="button" data-toggle="modal" title="View">
														<?php echo $in['Inbox']['subject']; ?>
														</a>
													</td>
													<td><?php echo $this->Time->timeAgoInWords($in['Inbox']['date']); ?></td>
													<td align='center'>
														<?php echo $this->Form->postLink('<img alt="delete" width="17" src ="/lynkd/img/../images/icons/admins/delete.png"/>',array('controller'=>'Inboxes','action'=>'trash',$in['Inbox']['id'],'sent'),array('escape'=>false,'class'=>'','title'=>'Move to Trash'));?>    
													</td> 
												</tr><?php 
									$i++;	}
									}
									?>				
								</tbody>
							</table> 
						</div>
					</div>
				</div>
				<?php } ?>
				<!--==================== Show single sent message ========================-->
				<div style="display: none;" id="showOutboxMsg">
					<div class="rightCol">
						<div class="blueHeading">View Message</div>
						<div class="messageInfo"><div id="viewOutboxMsg"></div></div>
					</div>
				</div>
				
				<!--==================== Write a message ========================-->
				<div style="display: none;" id="write">
					<div class="rightCol">
						<?php  echo $this->Element('messageToFriend'); ?>
					</div>
				</div>
				<!--====================Show all the Trash message========================-->
				<?php  if($t == 'trash'){ ?>
				<div style="display: block;" id="aa">
					<div class="rightCol">
						<div class="blueHeading">Trash</div>
						<div class="messageInfo" id="beforeRequest">
							<table class="table" id="viewinbox">
									<tr>
										<th> S. No.</th>
										<th>From</th>
										<th>Subject</th>
									</tr>
									<?php  
									
									if(count($trash)==0){ 
										echo '<tr><td colspan="5">No record found.</td></tr>';
									}
									else{ 
										if(!empty($trash)){ $i=1;
											foreach($trash as $in){  
													//if($in['Inbox']['status']=='Unread'){ $class = 'even'; }else{ $class = 'odd'; }
													?><tr>
														<td><?php echo $i; ?></td>
														<td>
															<a onclick="view_inbox(<?php echo $in['Inbox']['id']; ?>)" class="message" role="button" data-toggle="modal" title="View">
																<?php echo $in['Inbox']['from']; ?>
															</a>
														</td>
														<td>
															<a onclick="view_inbox(<?php echo $in['Inbox']['id']; ?>)" class="message" role="button" data-toggle="modal" title="View">
															<?php echo $in['Inbox']['subject']; ?>
															</a>
														</td>
														
													</tr><?php 
											$i++; }
										}
										else{
												echo '<tr><td colspan="5">No record found</td></tr>';
										}
									}
									?>
							</table>
						</div>
					</div>
				</div>
			   <?php } ?>
			   <!--==================== Show single inbox message ========================-->
             
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
            </section>
			<!--==================== Left side tab jqeury ========================-->
			<script type="text/javascript">
				/* $("#usual1").idTabs(); */
				function get_inbox_count(){
						var user_id = '<?php echo $this->Session->read('Auth.User.email'); ?>';
						$.ajax({
							type:'get',
							url:'<?php  echo Router::url(array('controller'=>'inboxes','action'=>'get_inbox_count')); ?>/'+user_id,
							success:function(result){
										$("#ffcount").text(result);						
									}
						});
						return false;
				}
				
				$(document).ready(function(){
					//get_friend_notification();
					setInterval(function () { get_inbox_count();  }, 3000);
				});
			</script>
			
		</div>
		<?php //echo $this->Element('friend_section'); ?>
	</section>
 </section>