<tbody>				
				<?php  if(!empty($friend_lists)){ ?>
				<?php foreach($friend_lists as $fl) { 
							?>
							 
					<tr id="<?php  echo $fl['Friend']['id'].'a';?>">	
						 <?php if($fl['Friend']['from_user_id'] == $this->Session->read('Auth.User.id')){  ?>
							<td><?php  echo $this->Html->image('/files/profileimage/'.($fl['User']['profile_image']!=''?$fl['User']['profile_image']:'user.png'),array('height'=>'72','width'=>'72')); ?></td>
							<td><?php echo 'Name: '.$fl['User']['name'].' '.$fl['User']['last_name'].'<br />'.'Email: '.$fl['User']['email']; ?></td>
						<?php } else { ?>
							<td><?php  echo $this->Html->image('/files/profileimage/'.($fl['FromUser']['profile_image']!=''?$fl['FromUser']['profile_image']:'user.png'),array('height'=>'72','width'=>'72')); ?></td>
							<td><?php echo 'Name: '.$fl['FromUser']['name'].' '.$fl['FromUser']['last_name'].'<br />'.'Email: '.$fl['FromUser']['email']; ?></td>
						<?php } ?>	
							<td id="<?php  echo $fl['Friend']['id'].'b';?>">
							<?php if($fl['Friend']['status'] == (int) 0 && $fl['Friend']['to_user_id'] == $this->Session->read('Auth.User.id')){ 
											echo $this->Html->link('Accept','javascript:void(0);',array('onclick'=>'return accept_request(\''.$fl['Friend']['id'].'\');')).' | '.$this->Html->link('Reject','javascript:void(0);',array('onclick'=>'return reject_request(\''.$fl['Friend']['id'].'\');'));
									} elseif($fl['Friend']['status'] == (int) 0 && $fl['Friend']['to_user_id'] != $this->Session->read('Auth.User.id')){
											echo 'Friend request sent';
									}									
									else { 
											echo $this->Html->link('Unfriend','javascript:void(0);',array('onclick'=>'return unfriend_user(\''.$fl['Friend']['id'].'\');'));
									} ?>
							</td>												
					</tr>
				<?php } } else { ?>
						<tr>												
							<td colspan="4" align="center">No friend added so far</td>
						</tr>											
				<?php } ?>
</tbody>